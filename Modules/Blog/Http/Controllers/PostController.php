<?php

namespace Modules\Blog\Http\Controllers;

use App\Exceptions\RepositoryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;
use Modules\Blog\Repositorires\Contracts\PostRepositoryInterface;

class PostController extends Controller
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * PostController constructor.
     * @param PostRepositoryInterface $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param $request
     * @return array
     * @throws ValidationException
     */
    private function validateRequest($request)
    {
        $rules = [
            'title'   => 'required',
            'content' => 'required',
        ];

        return $this->validate($request, $rules);
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $eagerLoad = $request->get('load', []);
        $this->postRepository->with($eagerLoad);

        if ($request->get('all')) {
            return response()->json($this->postRepository->all());
        }

        $paginator = $this->postRepository->advancedPaginate(
            $request->get('filter', []),
            $request->get('sort', []),
            $request->get(config('pagination.page_name'), 1),
            $request->get(config('pagination.per_page_name'), config('pagination.per_page_number'))
        );

        return response()->json($paginator);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        return response()->json($this->postRepository->create($data), Response::HTTP_CREATED);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show(Request $request, $id)
    {
        return response()->json(
            $this->postRepository->with($request->get('load', []))->findById($id)
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $data = $this->validateRequest($request);

        try {
            return response()->json(
                $this->postRepository->updateById($id, $data),
                Response::HTTP_ACCEPTED
            );
        } catch (RepositoryException $e) {
            return response()->json($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->postRepository->deleteById($id);

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (RepositoryException $e) {
            return response()->json($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
}
