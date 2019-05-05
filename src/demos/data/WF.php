<?php


namespace khans\utils\demos\data;

use raoul2000\workflow\source\file\IWorkflowDefinitionProvider;

class WF implements IWorkflowDefinitionProvider
{
    public function getDefinition()
    {
        return [
            'initialStatusId' => 'One',
            'status'          => [
                'One'   => [
                    'transition' => ['Two'],
                    'label'      => 'یکم',
                    'metadata'   => [
                        'description' => 'Start Status',
//                        'email' => ['mailer', 'tester'],
//                        'email' => false,
//                        'email' => true,
//                        'email' => 'Some template string',
//                        'email' => function($model) { return $model->id; },
                    ],
                ],
                'Two'   => [
                    'transition' => ['One', 'Three'],
                    'label'      => 'دوم',
                    'metadata'   => [
                        'email' => true,
                    ],
                ],
                'Three' => [
                    'transition' => ['Two', 'Four'],
                    'label'      => 'سوم',
                    'metadata'   => [
                        'email' => false,
                    ],
                ],
                'Four'  => [
                    'transition' => ['Three', 'Five'],
                    'label'      => 'چهارم',
                    'metadata'   => [
                        'email' => 'Link to some template',
                    ],
                ],
                'Five'  => [
                    'transition' => ['Four'],
                    'label'      => 'پنجم',
                    'metadata'   => [
                        'email' => function($model) { return $model->id; },
                    ],
                ],
            ],
        ];
    }
}