<?php


namespace khans\utils\demos\workflow;

/**
 *
 * @author keyhan
 */
class Multiple3WF extends WF
{
    public function getDefinition() {
        $definitions = parent::getDefinition();

        $definitions['metadata'] = [
            'description' => 'Third WF for mixed use',
            'email'       => 'Third config email template',
        ];

        $definitions['status']['Four']['transition'][] = 'Fifteen';

        $definitions['status']['Fifteen'] = [
            'transition' => ['Four', 'Sixteen'],
            'label'      => 'Level fifteen from 3',
            'metadata'   => [
                'actor' => 'Actor_3',
                'description' => 'Level labeled 15',
                'email' => 'Link to some template container {id}: {title}',
            ],
        ];
        $definitions['status']['Sixteen'] = [
            'transition' => ['Fifteen'],
            'label'      => 'Level sixteen from 3',
            'metadata'   => [
                'actor' => 'Actor_1',
                'description' => 'Level labeled 16',
                'email' => 'Link to some template container {id}: {title}',
            ],
        ];

        return $definitions;
    }
}

