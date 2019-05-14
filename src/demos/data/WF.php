<?php


namespace khans\utils\demos\data;

use raoul2000\workflow\source\file\IWorkflowDefinitionProvider;

class WF implements IWorkflowDefinitionProvider
{

    public function getDefinition() {
        return [
            'initialStatusId' => 'One',
            'metadata'        => [
                'description' => 'گردش کار دارای ...',
                'email'       => 'ایمیل ارسال شده برای حالات عمومی آزمایشی',
            ],
            'status'          => [
                'One'   => [
                    'transition' => ['Two'],
                    'label'      => 'یکم',
                    'metadata'   => [
                        'description' => 'Start Status sample description',
//                        'email' => false,
//                        'email' => true,
//                        'email' => 'Some fixed string',
//                        'email' => 'Link to some EAV-enabled template {test_eav_workflow}',
//                        'email' => 'Link to some template container {id}: {title}',
                    ],
                ],
                'Two'   => [
                    'transition' => ['One', 'Three'],
                    'label'      => 'دوم',
                    'metadata'   => [
                        'actor' => 'Actor_1',
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
                        'email' => 'Link to some EAV-enabled template {test_eav_workflow}',
                    ],
                ],
                'Five'  => [
                    'transition' => ['Four'],
                    'label'      => 'پنجم',
                    'metadata'   => [
                        'email' => 'Link to some template container {id}: {title}',
                    ],
                ],
            ],
        ];
    }
}