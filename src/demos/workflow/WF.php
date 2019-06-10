<?php


namespace khans\utils\demos\workflow;

use raoul2000\workflow\source\file\IWorkflowDefinitionProvider;

class WF implements IWorkflowDefinitionProvider
{

    public function getDefinition() {
        return [
            'initialStatusId' => 'One',
            'metadata'        => [
                'description' => 'Some simple base workflow',
                'email'       => 'general email template',
            ],
            'status'          => [
                'One'   => [
                    'transition' => ['Two'],
                    'label'      => 'First Level',
                    'metadata'   => [
                        'description' => 'Start status sample description',
                        'email' => false,
                        'actor' => 'inquirer',
                    ],
                ],
                'Two'   => [
                    'transition' => ['One', 'Three'],
                    'label'      => 'Level Two',
                    'metadata'   => [
                        'description' => 'Second status description',
                        'actor' => 'Actor_1',
                        'email' => true,
                    ],
                ],
                'Three' => [
                    'transition' => ['Two', 'Four'],
                    'label'      => 'Level Three',
                    'metadata'   => [
                        'description' => 'Third status description',
                        'actor' => 'Actor_2',
                        'email' => false,
                    ],
                ],
                'Four'  => [
                    'transition' => ['Three', 'Five'],
                    'label'      => 'Level Four',
                    'metadata'   => [
                        'description' => 'Fourth status description',
                        'actor' => 'Actor_3',
                        'email' => 'Link to some EAV-enabled template {test_eav_workflow}',
                    ],
                ],
                'Five'  => [
                    'transition' => ['Four'],
                    'label'      => 'Level Five',
                    'metadata'   => [
                        'description' => 'Fifth status description',
                        'actor' => 'Actor_1',
                        'email' => 'Link to some template container {id}: {title}',
                    ],
                ],
            ],
        ];
    }
}