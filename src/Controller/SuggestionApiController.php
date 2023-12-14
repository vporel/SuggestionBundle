<?php
namespace SuggestionBundle\Controller;

use RootBundle\Controller\AbstractApiController;
use SuggestionBundle\Entity\Suggestion;
use SuggestionBundle\SuggestionService;
use Symfony\Component\HttpFoundation\Request;

class SuggestionApiController extends AbstractApiController{

    public function __construct(private SuggestionService $suggestionService){}

    public function getCollection()
    {
        return $this->success(array_reverse($this->suggestionService->all()));
    }

    public function createSuggestion(Request $request): Suggestion
    {
        $suggestion = new Suggestion();
        $suggestion
            ->setSubject($request->request->get("subject"))
            ->setMessage($request->request->get("message"))
        ;
        $this->suggestionService->add($suggestion);
        $this->suggestionService->flush();
        return $suggestion;
    }

    public function deleteSuggestion(int $id)
    {
        $this->suggestionService->remove($id);
        $this->suggestionService->flush();
        return null;
    }

    public function clearSuggestions()
    {
        $this->suggestionService->clear();
        return null;
    }
}
