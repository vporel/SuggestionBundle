<?php

namespace SuggestionBundle\Entity;

use Symfony\Component\Serializer\Annotation as Serializer;
use ApiPlatform\Metadata as Api;
use SuggestionBundle\Controller\SuggestionApiController;
use Symfony\Component\Validator\Constraints as Assert;

#[
    Api\ApiResource(paginationEnabled: false, normalizationContext: ["groups" => ["default"]]),
    Api\GetCollection(
        controller: SuggestionApiController::class."::getCollection", read: false,
    ),
    Api\Post(
        controller: SuggestionApiController::class."::createSuggestion", write: false,
        openapiContext: [
            "requestBody" => ["content" => ["application/json" => ["schema" => ["type" => "object", "properties" => [
                "subject" => ["type" => "string", "required" => true],
                "message" => ["type" => "string", "required" => true, "description" => "La suggestion"],
            ]]]]]
        ]
    ),
    Api\Delete(
        controller: SuggestionApiController::class."::deleteSuggestion", read: false, write: false,
        requirements: ["id" => "\d+"]
    ),
    Api\Delete(
        uriTemplate: "/suggestions/clear",
        controller: SuggestionApiController::class."::clearSuggestions", read: false, write: false,
    )
]
class Suggestion
{
    /** @var int */
    #[Serializer\Groups("default")]
    private $id;

    /** @var \DateTime */
    #[Serializer\Groups("default")]
    private $createdAt;
    
    /** @var string */
    #[Serializer\Groups("default")]
    #[Assert\NotBlank]
    private $subject;
    
    /** @var string */
    #[Serializer\Groups("default")]
    #[Assert\Length(min: 10)]
    private $message;

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
 
    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;
        
        return $this;
    }
 
    public function setId(int $id): self
    {
        $this->id = $id;
        $this->createdAt = new \DateTime();

        return $this;
    }
}
