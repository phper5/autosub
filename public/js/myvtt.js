var autoKeyword = "auto";
var directionSetting = {
    "": true,
    "lr": true,
    "rl": true
};
var alignSetting = {
    "start": true,
    "middle": true,
    "end": true,
    "left": true,
    "right": true
};

function Vtt( buffer) {
    /**
     * 待解析文本
     */
    this.buffer = buffer;
    /**
     * 当前状态
     * @type {string}
     */
    this.state = "INITIAL";
    /**
     * 当前的cue
     * @type {VTTCue}
     */
    this.cue = new VTTCue(0, 0, "");

    this.cueList  = [];

    this.currentTime = 0;

    this.showedCueList = [];

    this.max_id = 0;

}

Vtt.prototype.deleteCurrentText  = function(){
    for (i=0;i<this.showedCueList.length;i++){
        cue = this.showedCueList[i];
        $("#zm"+cue.id).remove();
        this.showedCueList.splice(i,1);
        i--;
        for (j=0;j<this.cueList.length;j++){
            if (this.cueList[j] == cue){
                this.cueList.splice(j,1);
                break;
            }
        }
    }
}

Vtt.prototype.cleanShow = function(){
    for (i=0;i<this.showedCueList.length;i++){
        cue = this.showedCueList[i];

            $("#zm"+cue.id).remove();
            this.showedCueList.splice(i,1);
            i--;


    }
}
Vtt.prototype.playTo = function(time){
    for (i=0;i<this.showedCueList.length;i++){
        cue = this.showedCueList[i];
        if (cue.endTime<time || cue.startTime>time){
            $("#zm"+cue.id).remove();
            this.showedCueList.splice(i,1);
            i--;

        }

    }
    for (i=0;i<this.cueList.length;i++){
        cue = this.cueList[i];
        if (cue.startTime > time) {
            break;
        }
        if (cue.endTime>=time && cue.startTime<=time){
            if($.inArray(cue,this.showedCueList) < 0)
            {
                $("#zmlist").append("<div class='zmtext' id='zm"+cue.id+"'>"+cue.text+"</div>")

                this.showedCueList.push(cue);
            }
        }

    }
    console.log('end');
}

function up(x,y){
    return x.startTime -y.startTime;
}
Vtt.prototype.insertCue = function (startTime,endTime,text) {
    cue = new VTTCue(startTime, endTime, text);
    cue.id = ++this.max_id;
    this.cueList.push(cue)
    this.cueList.sort(up);
}

Vtt.prototype.getRawText = function(){
    $start = "WEBVTT\n\n";
    for ($i=1;$i<=this.cueList.length;$i++) {
        $cue = this.cueList[$i-1];
        $start += $i+"\n"+parseTimeStampToVideoFormat($cue.startTime)+" --> "+parseTimeStampToVideoFormat($cue.endTime)+"\n"+$cue.text+"\n\n"
    }
    return $start;
}

Vtt.prototype.addBuffer =  function(buffer){
    this.buffer +=buffer;
}
/**
 * 读取一行
 * @returns {string}
 */
Vtt.prototype.collectNextLine = function(){
    self  = this;
    var buffer = self.buffer;
    var pos = 0;
    while (pos < buffer.length && buffer[pos] !== '\r' && buffer[pos] !== '\n') {
        ++pos;
    }
    var line = buffer.substr(0, pos);
    // Advance the buffer early in case we fail below.
    if (buffer[pos] === '\r') {
        ++pos;
    }
    if (buffer[pos] === '\n') {
        ++pos;
    }
    self.buffer = buffer.substr(pos);
    return line;
}

Vtt.prototype.parsedCue = function () {
    this.cueList.push(this.cue)
    this.oncue && this.oncue(this.cue);
    this.cue = null;
}

Vtt.prototype.parse = function () {
    self = this;
    try{
        var line;

        if (self.state === "INITIAL") {
            // We can't start parsing until we have the first line.
            if (!/\r\n|\n/.test(self.buffer)) {
                return this;
            }

            line = this.collectNextLine();

            var m = line.match(/^WEBVTT([ \t].*)?$/);
            if (!m || !m[0]) {
                throw new ParsingError(ParsingError.Errors.BadSignature);
            }

            self.state = "HEADER";
        }

        var alreadyCollectedLine = false;
        while (self.buffer) {
            // We can't parse a line until we have the full line.
            if (!/\r\n|\n/.test(self.buffer)) {
                return this;
            }

            if (!alreadyCollectedLine) {
                line = this.collectNextLine();
            } else {
                alreadyCollectedLine = false;
            }

            switch (self.state) {
                case "HEADER":
                    // 13-18 - Allow a header (metadata) under the WEBVTT line.
                    if (/:/.test(line)) {
                        //header暂不处理
                    } else if (!line) {
                        // An empty line terminates the header and starts the body (cues).
                        self.state = "ID";
                    }
                    continue;
                case "NOTE":
                    // Ignore NOTE blocks.
                    if (!line) {
                        self.state = "ID";
                    }
                    continue;
                case "ID":
                    // Check for the start of NOTE blocks.
                    if (/^NOTE($|[ \t])/.test(line)) {
                        self.state = "NOTE";
                        break;
                    }
                    // 19-29 - Allow any number of line terminators, then initialize new cue values.
                    if (!line) {
                        continue;
                    }
                    self.cue = new VTTCue(0, 0, "");
                    self.state = "CUE";
                    // 30-39 - Check if self line contains an optional identifier or timing data.
                    if (line.indexOf("-->") === -1) {
                        self.cue.id = line;
                        self.max_id = line;
                        continue;
                    }
                // Process line as start of a cue.
                /*falls through*/
                case "CUE":
                    // 40 - Collect cue timings and settings.
                    try {
                        parseCue(line, self.cue, new Array());
                    } catch (e) {
                        console.log(e);
                        //self.reportOrThrowError(e);
                        // In case of an error ignore rest of the cue.
                        self.cue = null;
                        self.state = "BADCUE";
                        continue;
                    }
                    self.state = "CUETEXT";
                    continue;
                case "CUETEXT":
                    var hasSubstring = line.indexOf("-->") !== -1;
                    // 34 - If we have an empty line then report the cue.
                    // 35 - If we have the special substring '-->' then report the cue,
                    // but do not collect the line as we need to process the current
                    // one as a new cue.
                    if (!line || hasSubstring && (alreadyCollectedLine = true)) {
                        // We are done parsing self cue.

                        this.parsedCue();
                        self.state = "ID";
                        continue;
                    }
                    if (self.cue.text) {
                        self.cue.text += "\n";
                    }
                    self.cue.text += line;
                    continue;
                case "BADCUE": // BADCUE
                    // 54-62 - Collect and discard the remaining cue.
                    if (!line) {
                        self.state = "ID";
                    }
                    continue;
            }
        }
    } catch (e) {
        //self.reportOrThrowError(e);
        console.log(e);

        // If we are currently parsing a cue, report what we have.
        if (self.state === "CUETEXT" && self.cue && self.oncue) {
            self.oncue(self.cue);
        }
        self.cue = null;
        // Enter BADWEBVTT state if header was not parsed correctly otherwise
        // another exception occurred so enter BADCUE state.
        self.state = self.state === "INITIAL" ? "BADWEBVTT" : "BADCUE";
    }
    return this;
}
function parseTimeStampToVideoFormat(times) {
    var hour = Math.floor(times/3600);
    var min = Math.floor(times/60) % 60;
    var sec = times % 60;
    if(hour < 10) {
        t = '0'+ hour + ":";
    } else {
        t = hour + ":";
    }
    if(min < 10){t += "0";}
    t += min + ":";
    if(sec < 10){t += "0";}
    t += sec.toFixed(3);
    return t;

}
// Try to parse input as a time stamp.
function parseTimeStamp(input) {

    function computeSeconds(h, m, s, f) {
        return (h | 0) * 3600 + (m | 0) * 60 + (s | 0) + (f | 0) / 1000;
    }

    var m = input.match(/^(\d+):(\d{2})(:\d{2})?\.(\d{3})/);
    if (!m) {
        return null;
    }

    if (m[3]) {
        // Timestamp takes the form of [hours]:[minutes]:[seconds].[milliseconds]
        return computeSeconds(m[1], m[2], m[3].replace(":", ""), m[4]);
    } else if (m[1] > 59) {
        // Timestamp takes the form of [hours]:[minutes].[milliseconds]
        // First position is hours as it's over 59.
        return computeSeconds(m[1], m[2], 0,  m[4]);
    } else {
        // Timestamp takes the form of [minutes]:[seconds].[milliseconds]
        return computeSeconds(0, m[1], m[2], m[4]);
    }
}


function parseCue(input, cue, regionList) {
    // Remember the original input if we need to throw an error.
    var oInput = input;
    // 4.1 WebVTT timestamp
    function consumeTimeStamp() {
        var ts = parseTimeStamp(input);
        if (ts === null) {
            throw new ParsingError(ParsingError.Errors.BadTimeStamp,
                "Malformed timestamp: " + oInput);
        }
        // Remove time stamp from input.
        input = input.replace(/^[^\sa-zA-Z-]+/, "");
        return ts;
    }

    // 4.4.2 WebVTT cue settings
    function consumeCueSettings(input, cue) {
        var settings = new Settings();

        parseOptions(input, function (k, v) {
            switch (k) {
                case "region":
                    // Find the last region we parsed with the same region id.
                    for (var i = regionList.length - 1; i >= 0; i--) {
                        if (regionList[i].id === v) {
                            settings.set(k, regionList[i].region);
                            break;
                        }
                    }
                    break;
                case "vertical":
                    settings.alt(k, v, ["rl", "lr"]);
                    break;
                case "line":
                    var vals = v.split(","),
                        vals0 = vals[0];
                    settings.integer(k, vals0);
                    settings.percent(k, vals0) ? settings.set("snapToLines", false) : null;
                    settings.alt(k, vals0, ["auto"]);
                    if (vals.length === 2) {
                        settings.alt("lineAlign", vals[1], ["start", "middle", "end"]);
                    }
                    break;
                case "position":
                    vals = v.split(",");
                    settings.percent(k, vals[0]);
                    if (vals.length === 2) {
                        settings.alt("positionAlign", vals[1], ["start", "middle", "end"]);
                    }
                    break;
                case "size":
                    settings.percent(k, v);
                    break;
                case "align":
                    settings.alt(k, v, ["start", "middle", "end", "left", "right"]);
                    break;
            }
        }, /:/, /\s/);

        // Apply default values for any missing fields.
        cue.region = settings.get("region", null);
        cue.vertical = settings.get("vertical", "");
        cue.line = settings.get("line", "auto");
        cue.lineAlign = settings.get("lineAlign", "start");
        cue.snapToLines = settings.get("snapToLines", true);
        cue.size = settings.get("size", 100);
        cue.align = settings.get("align", "middle");
        cue.position = settings.get("position", "auto");
        cue.positionAlign = settings.get("positionAlign", {
            start: "start",
            left: "start",
            middle: "middle",
            end: "end",
            right: "end"
        }, cue.align);
    }

    function skipWhitespace() {
        input = input.replace(/^\s+/, "");
    }

    // 4.1 WebVTT cue timings.
    skipWhitespace();
    cue.startTime = consumeTimeStamp();   // (1) collect cue start time
    skipWhitespace();
    if (input.substr(0, 3) !== "-->") {     // (3) next characters must match "-->"
        throw new ParsingError(ParsingError.Errors.BadTimeStamp,
            "Malformed time stamp (time stamps must be separated by '-->'): " +
            oInput);
    }
    input = input.substr(3);
    skipWhitespace();
    cue.endTime = consumeTimeStamp();     // (5) collect cue end time

    // 4.1 WebVTT cue settings list.
    skipWhitespace();
    consumeCueSettings(input, cue);
}


var _objCreate = Object.create || (function() {
    function F() {}
    return function(o) {
        if (arguments.length !== 1) {
            throw new Error('Object.create shim only accepts one parameter.');
        }
        F.prototype = o;
        return new F();
    };
})();

function ParsingError(errorData, message) {
    this.name = "ParsingError";
    this.code = errorData.code;
    this.message = message || errorData.message;
}
ParsingError.prototype = _objCreate(Error.prototype);
ParsingError.prototype.constructor = ParsingError;

// ParsingError metadata for acceptable ParsingErrors.
ParsingError.Errors = {
    BadSignature: {
        code: 0,
        message: "Malformed WebVTT signature."
    },
    BadTimeStamp: {
        code: 1,
        message: "Malformed time stamp."
    }
};


function extend(obj) {
    var i = 1;
    for (; i < arguments.length; i++) {
        var cobj = arguments[i];
        for (var p in cobj) {
            obj[p] = cobj[p];
        }
    }

    return obj;
}

function parseOptions(input, callback, keyValueDelim, groupDelim) {
    var groups = groupDelim ? input.split(groupDelim) : [input];
    for (var i in groups) {
        if (typeof groups[i] !== "string") {
            continue;
        }
        var kv = groups[i].split(keyValueDelim);
        if (kv.length !== 2) {
            continue;
        }
        var k = kv[0];
        var v = kv[1];
        callback(k, v);
    }
}

/**
 * cue的定应
 * @param startTime
 * @param endTime
 * @param text
 * @returns {VTTCue}
 * @constructor
 */
function VTTCue(startTime, endTime, text) {
    var cue = this;
    var isIE8 = (/MSIE\s8\.0/).test(navigator.userAgent);
    var baseObj = {};

    if (isIE8) {
        cue = document.createElement('custom');
    } else {
        baseObj.enumerable = true;
    }

    /**
     * Shim implementation specific properties. These properties are not in
     * the spec.
     */

    // Lets us know when the VTTCue's data has changed in such a way that we need
    // to recompute its display state. This lets us compute its display state
    // lazily.
    cue.hasBeenReset = false;

    /**
     * VTTCue and TextTrackCue properties
     * http://dev.w3.org/html5/webvtt/#vttcue-interface
     */

    var _id = "";
    var _pauseOnExit = false;
    var _startTime = startTime;
    var _endTime = endTime;
    var _text = text;
    var _region = null;
    var _vertical = "";
    var _snapToLines = true;
    var _line = "auto";
    var _lineAlign = "start";
    var _position = 50;
    var _positionAlign = "middle";
    var _size = 50;
    var _align = "middle";

    Object.defineProperty(cue,
        "id", extend({}, baseObj, {
            get: function() {
                return _id;
            },
            set: function(value) {
                _id = "" + value;
            }
        }));

    Object.defineProperty(cue,
        "pauseOnExit", extend({}, baseObj, {
            get: function() {
                return _pauseOnExit;
            },
            set: function(value) {
                _pauseOnExit = !!value;
            }
        }));

    Object.defineProperty(cue,
        "startTime", extend({}, baseObj, {
            get: function() {
                return _startTime;
            },
            set: function(value) {
                if (typeof value !== "number") {
                    throw new TypeError("Start time must be set to a number.");
                }
                _startTime = value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "endTime", extend({}, baseObj, {
            get: function() {
                return _endTime;
            },
            set: function(value) {
                if (typeof value !== "number") {
                    throw new TypeError("End time must be set to a number.");
                }
                _endTime = value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "text", extend({}, baseObj, {
            get: function() {
                return _text;
            },
            set: function(value) {
                _text = "" + value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "region", extend({}, baseObj, {
            get: function() {
                return _region;
            },
            set: function(value) {
                _region = value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "vertical", extend({}, baseObj, {
            get: function() {
                return _vertical;
            },
            set: function(value) {
                // var setting = findDirectionSetting(value);
                // // Have to check for false because the setting an be an empty string.
                // if (setting === false) {
                //     throw new SyntaxError("An invalid or illegal string was specified.");
                // }
                // _vertical = setting;
                //temp
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "snapToLines", extend({}, baseObj, {
            get: function() {
                return _snapToLines;
            },
            set: function(value) {
                _snapToLines = !!value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "line", extend({}, baseObj, {
            get: function() {
                return _line;
            },
            set: function(value) {
                if (typeof value !== "number" && value !== autoKeyword) {
                    throw new SyntaxError("An invalid number or illegal string was specified.");
                }
                _line = value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "lineAlign", extend({}, baseObj, {
            get: function() {
                return _lineAlign;
            },
            set: function(value) {
                // var setting = findAlignSetting(value);
                // if (!setting) {
                //     throw new SyntaxError("An invalid or illegal string was specified.");
                // }
                // _lineAlign = setting;
                //临时跳过
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "position", extend({}, baseObj, {
            get: function() {
                return _position;
            },
            set: function(value) {
                if (value < 0 || value > 100) {
                    throw new Error("Position must be between 0 and 100.");
                }
                _position = value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "positionAlign", extend({}, baseObj, {
            get: function() {
                return _positionAlign;
            },
            set: function(value) {
                // var setting = findAlignSetting(value);
                // if (!setting) {
                //     throw new SyntaxError("An invalid or illegal string was specified.");
                // }
                // _positionAlign = setting;
                //临时跳过
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "size", extend({}, baseObj, {
            get: function() {
                return _size;
            },
            set: function(value) {
                if (value < 0 || value > 100) {
                    throw new Error("Size must be between 0 and 100.");
                }
                _size = value;
                this.hasBeenReset = true;
            }
        }));

    Object.defineProperty(cue,
        "align", extend({}, baseObj, {
            get: function() {
                return _align;
            },
            set: function(value) {
                // var setting = findAlignSetting(value);
                // if (!setting) {
                //     throw new SyntaxError("An invalid or illegal string was specified.");
                // }
                // _align = setting;
                //临时
                this.hasBeenReset = true;
            }
        }));

    /**
     * Other <track> spec defined properties
     */

    // http://www.whatwg.org/specs/web-apps/current-work/multipage/the-video-element.html#text-track-cue-display-state
    cue.displayState = undefined;

    if (isIE8) {
        return cue;
    }
}



/**
 * 字幕配置
 * @type {{set: Settings.set, get: Settings.get, alt: Settings.alt, has: (function(*): boolean), integer: Settings.integer, percent: Settings.percent}}
 */
function Settings() {
    this.values = _objCreate(null);
}
Settings.prototype = {
    // Only accept the first assignment to any key.
    set: function(k, v) {
        if (!this.get(k) && v !== "") {
            this.values[k] = v;
        }
    },
    // Return the value for a key, or a default value.
    // If 'defaultKey' is passed then 'dflt' is assumed to be an object with
    // a number of possible default values as properties where 'defaultKey' is
    // the key of the property that will be chosen; otherwise it's assumed to be
    // a single value.
    get: function(k, dflt, defaultKey) {
        if (defaultKey) {
            return this.has(k) ? this.values[k] : dflt[defaultKey];
        }
        return this.has(k) ? this.values[k] : dflt;
    },
    // Check whether we have a value for a key.
    has: function(k) {
        return k in this.values;
    },
    // Accept a setting if its one of the given alternatives.
    alt: function(k, v, a) {
        for (var n = 0; n < a.length; ++n) {
            if (v === a[n]) {
                this.set(k, v);
                break;
            }
        }
    },
    // Accept a setting if its a valid (signed) integer.
    integer: function(k, v) {
        if (/^-?\d+$/.test(v)) { // integer
            this.set(k, parseInt(v, 10));
        }
    },
    // Accept a setting if its a valid percentage.
    percent: function(k, v) {
        var m;
        if ((m = v.match(/^([\d]{1,3})(\.[\d]*)?%$/))) {
            v = parseFloat(v);
            if (v >= 0 && v <= 100) {
                this.set(k, v);
                return true;
            }
        }
        return false;
    }
};
