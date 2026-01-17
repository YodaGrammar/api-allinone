<?php

declare(strict_types=1);

namespace App\Controller;

class readonly CreateActivityController {

    public function __construct(
        private SerializerInterface $serializer,
        private ValidatorInterface $validator,1
    ){}

    public function __invoke(Request $request){

        $activityDto = $this->serializer->deserialize($request->getContent(), CreateActivityRequestDto::class, 'json');

        $violations = $this->validator->validate($activityDto);

        if ( $violations->count() > 0) {
            throw new InvalidJsonVerboseException($violations, CreateActivityRequestDto::class);
        }

    }
}
