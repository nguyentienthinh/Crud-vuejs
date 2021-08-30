<?php

// PostController.php

namespace App\Http\Controllers;

use App\Exceptions\NoContentException;
use App\Exceptions\NotFoundException;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostCollection;
use App\Post;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

/**
 * PostController class
 */
class PostController extends Controller
{
    // Response data: status and message
    private $status;
    private $message;

    /**
     * Show function
     *
     * @return object
     */
    public function index()
    {
        $logging = Log::channel('post_get_list');
        $logging->info('[START] Post Get List--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        try {
            // Get data
            $data = new PostCollection(Post::select('id', 'title', 'body', 'slug')->get());

            // Check data
            if (empty($data)) {
                $logging->error('Post: Get list Empty!');
                throw new NoContentException();
            }

            $logging->info('Post: Get list success!');
        } catch (NoContentException $e) {
            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = $e->getStatus();
            $this->message = $e->getMessage();
        } catch (Exception $e) {
            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = config('constants.status.ERROR.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        $logging->info('[END] Post Get List--------------------');

        return $this->formatResponseData($data);
    }

    /**
     * Store function
     *
     * @param PostRequest $request
     * @return string
     */
    public function store(PostRequest $request)
    {
        $logging = Log::channel('post_create');
        $logging->info('[START] Post Create--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        try {
            $logging->info('Data request: ' . json_encode($request->all()));

            // Create post
            DB::beginTransaction();
            $post = Post::create(
                [
                    'title' => $request->get('title'),
                    'body' => $request->get('body')
                ]
            );

            // Auto generate slug is unique
            $post->replicate();

            DB::commit();

            $logging->info('Post: Create success!');
        } catch (Exception $e) {
            DB::rollBack();

            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = config('constants.status.status.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        $logging->info('[END] Post Create--------------------');
        return $this->formatResponseData();
    }

    /**
     * Edit function function
     *
     * @param string $slug
     * @return string
     */
    public function edit($slug)
    {
        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        try {
            $post = Post::where('slug', $slug)->first();
            // Check post exist
            if (empty($post)) {
                throw new NotFoundException();
            }
        } catch (NotFoundException $e) {
            $this->status = $e->getStatus();
            $this->message = $e->getMessage();
        } catch (Exception $e) {
            $this->status = config('constants.status.ERROR.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        return $this->formatResponseData($post);
    }

    /**
     * Update function
     *
     * @param PostRequest $request
     * @param string $slug
     * @return string
     */
    public function update(PostRequest $request, $slug)
    {
        $logging = Log::channel('post_update');
        $logging->info('[START] Post Update--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        try {
            $logging->info('Data request: ' . json_encode($request->all()));

            // Check post exist
            $post = Post::where('slug', $slug)->first();
            if (empty($post)) {
                throw new NoContentException();
            }

            // Update
            DB::beginTransaction();
            $post->update($request->all());
            DB::commit();
        } catch (NoContentException $e) {
            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = $e->getStatus();
            $this->message = $e->getMessage();
        } catch (Exception $e) {
            DB::rollBack();

            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = config('constants.status.ERROR.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        $logging->info('[END] Post Update--------------------');

        return $this->formatResponseData();
    }

    /**
     * Delete function
     *
     * @return string
     */
    public function delete($slug)
    {
        $logging = Log::channel('post_delete');
        $logging->info('[START] Post Delete--------------------');

        // Init status and message
        $this->setUpStatusAndMessageSuccess();

        try {
            // Check post exist
            $post = Post::where('slug', $slug)->first();
            if (empty($post)) {
                throw new NoContentException();
            }

            // Delete post
            DB::beginTransaction();
            $post->delete();
            DB::commit();

            $logging->info('Post: Delete success!');
        } catch (NoContentException $e) {
            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = $e->getStatus();
            $this->message = $e->getMessage();
        } catch (Exception $e) {
            DB::rollBack();

            $logging->error('Post Error: ' . $e->getMessage());

            $this->status = config('constants.status.ERROR.OTHER');
            $this->message = config('constants.status.message.OTHER');
        }

        $logging->info('[END] Post Delete--------------------');

        return $this->formatResponseData();
    }

    /**
     * Format response data function
     *
     * @param object $data
     * @return string
     */
    private function formatResponseData($data = null)
    {
        $responseData = [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $data
        ];

        return response()->json($responseData);
    }

    /**
     * Set up status and message is success
     *
     * @return void
     */
    private function setUpStatusAndMessageSuccess()
    {
        $this->status = config('constants.status.OK');
        $this->message = config('constants.message.OK');
    }
}
