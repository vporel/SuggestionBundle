<?php

namespace SuggestionBundle;

use SuggestionBundle\Entity\Suggestion;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;

class SuggestionService{

    /** @var Suggestion[] */
    private $suggestions = [];
    private $path = null;

    public function __construct(protected ParameterBagInterface $parameterBag, private SerializerInterface $serializer)
    {
        
        $this->path = $parameterBag->get("suggestion")["file_path"];

        if(file_exists($this->path)){
            $suggestions = json_decode(file_get_contents($this->path), true);
            if(count($suggestions) > 0){
                foreach($suggestions as $sugg) $this->suggestions[] = $this->serializer->deserialize(json_encode($sugg), Suggestion::class, "json");
            }
        }else{
            file_put_contents($this->path, "[]");
            if(!is_writable($this->path)){
                unlink($this->path);
                throw new \RuntimeException("The file '".$this->path."' doesn't exists. The creation has failed.");
            }
        }
    }

    public function add(Suggestion $suggestion): void{
        $this->suggestions[] = $suggestion;
    }

    public function remove(int $id): void{
        $newList = array_filter($this->suggestions, function($s) use($id){return $s->getId() != $id; });
        if(count($newList) == count($this->suggestions)) throw new \Exception("No sugegstion with the id '$id'");
        $this->suggestions = $newList;
    }

    /**
     * @return Suggestion[]
     */
    public function all(): array{
        return $this->suggestions;
    }

    /**
     * Apply all the updates
     */
    public function flush(): void{
        foreach($this->suggestions as $sugg){
            if(!$sugg->getId()) $sugg->setId(time());
        }
        file_put_contents($this->path, $this->serializer->serialize($this->suggestions, "json"));
    }

    public function clear(): void{
        $this->suggestions = [];
        $this->flush();
    }
}