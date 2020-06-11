<?php


namespace App\Http\Controllers;


use App\User;
use Canvas\Events\PostViewed;
use Canvas\Post;
use Canvas\UserMeta;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AritcleController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::published()
            ->withUserMeta()
            ->orderByDesc('published_at')
            ->get();

        $posts->each->append('read_time');

//        return response()->json([
//            'posts' => $posts,
//        ]);
        return view('articles',['posts'=>$posts]);
    }
    private function isPublished($post): bool
    {
        return $post && $post->published;
    }
    protected function publicIdentifier(): string
    {
        return config('studio.identifier');
    }
    public function show(Request $request, string $identifier, string $slug = null)
    {
        $posts = Post::published()->withUserMeta()->get();
        $post = $posts->firstWhere('slug', $slug);

        if ($this->isPublished($post)) {
            switch ($this->publicIdentifier()) {
                case 'id':
                    $this->user = User::where('id', $identifier)->first();

                    if ($this->user) {
                        $this->userMeta = UserMeta::where('user_id', $this->user->id)->first();
                    }
                    break;

                case 'username':
                    $this->userMeta = UserMeta::where('username', $identifier)->first();

                    if ($this->userMeta) {
                        $this->user = User::where('id', $this->userMeta->user_id)->first();
                    }
                    break;

                default:
                    break;
            }

            $post->append('read_time');

            event(new PostViewed($post));

            return view('article',[
                'post' => $post,
//                'user' => $post->user,
//                'username' => optional($this->userMeta)->username,
//                'avatar' => !empty(optional($this->userMeta)->avatar) ? optional($this->userMeta)->avatar : $this->generateDefaultGravatar($this->user->email, 200),
                'meta' => $post->meta,
              //  'related' => $this->showRelated ? $this->getRelatedViaTaxonomy($post, $posts) : [],
            ]);

//            return response()->json([
//                'post' => $post,
//                'user' => $post->user,
//                'username' => optional($this->userMeta)->username,
//                'avatar' => !empty(optional($this->userMeta)->avatar) ? optional($this->userMeta)->avatar : $this->generateDefaultGravatar($this->user->email, 200),
//                'meta' => $post->meta,
//                'related' => $this->showRelated ? $this->getRelatedViaTaxonomy($post, $posts) : [],
//            ]);
        } else {
            throw new NotFoundHttpException();
            //return response()->json(null, 404);
        }
    }
}
