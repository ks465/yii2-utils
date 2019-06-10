<?php


namespace khans\utils\demos\workflow;

/**
 *
 * @author keyhan
 */
class Multiple2WF extends WF
{
    public function getDefinition() {
        $definitions = parent::getDefinition();

        $definitions['metadata'] = [
            'description' => 'Second WF for mixed use',
            'email'       => 'Second config email template',
        ];

        $definitions['status']['Four']['transition'][] = 'Thirteen';
        $definitions['status']['Three']['transition'][] = 'Fourteen';

        $definitions['status']['Thirteen'] = [
            'transition' => ['Four', 'Fourteen'],
            'label'      => 'Level thirteen from 2',
            'metadata'   => [
                'actor' => 'Actor_3',
                'description' => 'Level labeled 13',
                'email' => 'Link to some template container {id}: {title}',
            ],
        ];
        $definitions['status']['Fourteen'] = [
            'transition' => ['Thirteen'],
            'label'      => 'Level fourteen from 2',
            'metadata'   => [
                'actor' => 'Actor_2',
                'description' => 'Level labeled 14',
                'email' => 'Link to some template container {id}: {title}',
            ],
        ];

        return $definitions;
    }
}

