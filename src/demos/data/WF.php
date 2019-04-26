<?php


namespace khans\utils\demos\data;

use raoul2000\workflow\source\file\IWorkflowDefinitionProvider;

class WF implements IWorkflowDefinitionProvider
{
    public function getDefinition()
    {
        return static::$definitions;
    }

    private static $definitions = [
        'initialStatusId' => 'One',
        'status'          => [
            'One'   => [
                'transition' => ['Two'],
                'label'      => 'یکم',
                'metadata'   => [
                    'stage' => [1],
                ],
            ],
            'Two'   => [
                'transition' => ['One', 'Three'],
                'label'      => 'دوم',
                'metadata'   => [
                    'stage' => [2],
                ],
            ],
            'Three' => [
                'transition' => ['Two', 'Four'],
                'label'      => 'سوم',
                'metadata'   => [
                    'stage' => [3],
                ],
            ],
            'Four'  => [
                'transition' => ['Three'],
                'label'      => 'چهارم',
                'metadata'   => [
                    'stage' => [4],
                ],
            ],
        ],
    ];
}