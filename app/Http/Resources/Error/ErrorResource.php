<?php

namespace App\Http\Resources\Error;

use Illuminate\Http\JsonResponse;

/**
 * @see https://jsonapi.org/format/#error-objects
 */
class ErrorResource
{
    /**
     * @var string|int
     */
    private $id;
    private string $linkAbout = '';
    private int $statusCode;
    private string $applicationErrorCode = '';
    private string $title = '';
    private string $detail = '';
    private string $sourcePointer = '';
    private string $sourceParameter = '';
    private array $meta = [];
    private array $errorCollection = [];

    /**
     * A unique identifier for this particular occurrence of the problem.
     *
     * @param $id
     * @return $this
     */
    public function setId($id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * A links object containing the following members:
     * About: A link that leads to further details about this particular occurrence of the problem.
     *
     * @param string $about
     * @return $this
     */
    public function setLinks(string $about): self
    {
        $this->linkAbout = $about;

        return $this;
    }

    /**
     * The HTTP status code applicable to this problem, expressed as a string value.
     *
     * @param int $code
     * @return $this
     */
    public function setStatusCode(int $code): self
    {
        $this->statusCode = (string)$code;

        return $this;
    }

    /**
     * An application-specific error code, expressed as a string value.
     *
     * @param string $code
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->applicationErrorCode = $code;

        return $this;
    }

    /**
     * A short, human-readable summary of the problem that SHOULD NOT change from occurrence to occurrence of the problem,
     * except for purposes of localization.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * A human-readable explanation specific to this occurrence of the problem.
     * Like title, this field’s value can be localized.
     *
     * @param string $detail
     * @return $this
     */
    public function setDetail(string $detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * An object containing references to the source of the error, optionally including any of the following members:
     *
     * Pointer:
     * A JSON Pointer [RFC6901] to the associated entity in the request document
     * [e.g. "/data" for a primary data object, or "/data/attributes/title" for a specific attribute].
     *
     * Parameter:
     * A string indicating which URI query parameter caused the error.
     *
     * @param string|null $pointer
     * @param string|null $parameter
     * @return $this
     */
    public function setSource(string $pointer = null, string $parameter = null): self
    {
        if ($pointer !== null) {
            $this->sourcePointer = $pointer;
        }

        if ($parameter !== null) {
            $this->sourceParameter = $parameter;
        }

        return $this;
    }

    /**
     * A meta object containing non-standard meta-information about the error.
     *
     * @param array $meta
     * @return $this
     */
    public function setMeta(array $meta): self
    {
        $this->meta = $meta;

        return $this;
    }

    /**
     * Add an error to the errorCollection. Can get using getErrorCollection().
     *
     * @param null $id
     * @param string|null $aboutLink
     * @param int|null $statusCode
     * @param string|null $appErrorCode
     * @param string|null $title
     * @param string|null $detail
     * @param string|null $sourcePointer
     * @param string|null $sourceParameter
     * @param array|null $meta
     *
     * @return ErrorResource
     */
    public function addError(
        $id = null,
        string $aboutLink = null,
        int $statusCode = null,
        string $appErrorCode = null,
        string $title = null,
        string $detail = null,
        string $sourcePointer = null,
        string $sourceParameter = null,
        array $meta = null
    ): self {
        $error = [];

        if ($id) {
            $error['id'] = $id;
        }

        if ($aboutLink) {
            $error['links']['about'] = $aboutLink;
        }

        if ($statusCode) {
            $error['status'] = $statusCode;
        }

        if ($appErrorCode) {
            $error['code'] = $appErrorCode;
        }

        if ($title) {
            $error['title'] = $title;
        }

        if ($detail) {
            $error['detail'] = $detail;
        }

        if ($sourcePointer) {
            $error['source']['pointer'] = $sourcePointer;
        }

        if ($sourceParameter) {
            $error['source']['parameter'] = $sourceParameter;
        }

        if ($meta) {
            $error['meta'] = $meta;
        }

        array_push($this->errorCollection, $error);

        return $this;
    }

    /**
     * Returns the error as JsonResponse.
     *
     * @return JsonResponse
     */
    public function getError(): JsonResponse
    {
        $response = response()->json(
            $this->getErrorSkeleton()
        );

        if ($this->statusCode) {
            $response->setStatusCode($this->statusCode);
        }

        return $response;
    }

    /**
     * Returns the error collection as JsonResponse.
     *
     * @return JsonResponse
     */
    public function getErrorCollection(): JsonResponse
    {
        $response = response()->json(
            $this->getErrorCollectionSkeleton()
        );

        if ($this->statusCode) {
            $response->setStatusCode($this->statusCode);
        }

        return $response;
    }

    /**
     * Get the error skeleton structure.
     *
     * @return array
     */
    private function getErrorSkeleton(): array
    {
        $this->addError(
            $this->id,
            $this->linkAbout,
            $this->statusCode,
            $this->applicationErrorCode,
            $this->title,
            $this->detail,
            $this->sourcePointer,
            $this->sourceParameter,
            $this->meta
        );

        return $this->getBaseSkeleton($this->errorCollection);
    }

    /**
     * Get the errorCollection skeleton structure.
     *
     * @return array
     */
    private function getErrorCollectionSkeleton(): array
    {
        return $this->getBaseSkeleton($this->errorCollection);
    }

    /**
     * Get the base skeleton structure.
     *
     * @param array $errors
     * @return array
     */
    private function getBaseSkeleton(array $errors): array
    {
        return [
            'errors' => $errors,
        ];
    }
}
