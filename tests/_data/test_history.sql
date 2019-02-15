INSERT INTO `sys_history_database` (`id`, `user_id`, `date`, `table`, `field_name`, `field_id`, `old_value`,
                                    `new_value`, `type`)
VALUES (NULL, '101', '2019-02-01 19:16:49', 'test_entities', 'id', '1', NULL, NULL, 0),
       (NULL, '103', '2019-02-01 19:16:49', 'test_entities', 'id', '2', NULL, NULL, 0),
       (NULL, '3', '2019-02-01 19:17:35', 'test_entities', 'progress_status', '2', 'WF/draft', 'WF/referral', 1),
       (NULL, '102', '2019-02-01 19:16:49', 'test_entities', 'id', '3', NULL, NULL, 0),
       (NULL, '5', '2019-02-01 19:22:35', 'test_entities', 'progress_status', '3', 'WF/draft', 'WF/referral', 1),
       (NULL, '102', '2019-02-01 19:37:35', 'test_entities', 'progress_status', '3', 'WF/referral', 'WF/faculty', 1)
;
