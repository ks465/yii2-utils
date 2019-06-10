<?php


namespace khans\utils\demos\workflow;

use raoul2000\workflow\source\file\IWorkflowDefinitionProvider;

class DeficientWF implements IWorkflowDefinitionProvider
{

    public function getDefinition() {
        return [
            'initialStatusId' => 'One',
            'metadata'        => [
                'description' => 'Some simple and deficient workflow',
                'email'       => 'general email template',
            ],
            'status'          => [
                'One'   => [
                    'transition' => ['Two'],
                    'label'      => 'First Level',
                    'metadata'   => [
                        'description' => 'Start Status sample description',
                    ],
                ],
                'Two'   => [
                    'transition' => ['One', 'Three'],
                    'label'      => 'Level Two',
                    'metadata'   => [
                        'actor' => 'Actor_1',
                        'email' => true,
                    ],
                ],
                'Three' => [
                    'transition' => ['Two', 'Four'],
                    'label'      => 'Level Three',
                    'metadata'   => [
                        'description' => 'Middle Status without email description',
                        'email' => false,
                    ],
                ],
                'Four'  => [
                    'transition' => ['Three', 'Five'],
                    'label'      => 'Level Four',
                    'metadata'   => [
                        'email' => 'Link to some EAV-enabled template {test_eav_workflow}',
                    ],
                ],
                'Five'  => [
                    'transition' => ['Four'],
                    'label'      => 'Level Five',
                    'metadata'   => [
                        'actor' => 'Actor_1',
                        'email' => 'Link to some template container {id}: {title}',
                    ],
                ],
            ],
        ];
    }
}