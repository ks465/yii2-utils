<?php


namespace khans\utils\demos\workflow;

/**
 *
 * @author keyhan
 */
class Multiple1WF extends WF
{
    public function getDefinition() {
        $definitions = parent::getDefinition();

        $definitions['metadata'] = [
            'description' => 'First WF for mixed use',
            'email'       => 'First config email template',
        ];

        $definitions['status']['Four']['transition'][] = 'Eleven';
        $definitions['status']['Three']['transition'][] = 'Eleven';

        $definitions['status']['Eleven'] = [
            'transition' => ['Four', 'Twelve'],
            'label'      => 'Level eleven from 1',
            'metadata'   => [
                'actor' => 'Actor_1',
                'description' => 'Level labeled 11',
                'email' => 'Link to some template container {id}: {title}',
                'class' => 'success',
                'icon' => 'ok',
            ],
        ];
        $definitions['status']['Twelve'] = [
            'transition' => ['Three', 'Eleven'],
            'label'      => 'Level twelve from 1',
            'metadata'   => [
                'actor' => 'unknown',
                'description' => 'Test extended level labeled 12',
                'email' => 'Link to some template container {id}: {title}',
                'class' => 'danger',
                'icon' => 'cog',
            ],
        ];

        return $definitions;
    }
}

