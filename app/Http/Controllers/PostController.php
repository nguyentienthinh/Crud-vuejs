<?php

// PostController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Post;

/**
 * PostController class
 */
class PostController extends Controller
{
    /**
     * Show function
     *
     * @return object
     */
    public function index()
    {
        return new PostCollection(Post::all());
    }

    /**
     * Store function
     *
     * @param Request $request
     * @return string
     */
    public function store(Request $request)
    {
        $post = new Post(
            [
                'title' => $request->get('title'),
                'body' => $request->get('body')
            ]
        );

        $post->save();

        return response()->json('success');
    }

    /**
     * Edit function function
     *
     * @param int $id
     * @return string
     */
    public function edit($id)
    {
        $post = Post::find($id);
        return response()->json($post);
    }

    /**
     * Update function
     *
     * @param int $id
     * @param Request $request
     * @return string
     */
    public function update($id, Request $request)
    {
        $post = Post::find($id);

        $post->update($request->all());

        return response()->json('successfully updated');
    }

    /**
     * Delete function
     *
     * @param string $id
     * @return string
     */
    public function delete($id)
    {
        $post = Post::find($id);

        $post->delete();

        return response()->json('successfully deleted');
    }
}
