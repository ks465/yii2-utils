DROP TABLE IF EXISTS `test_entities`;
CREATE TABLE `test_entities` (
  `id` int(11) NOT NULL,
  `faculty_id` varchar(31) NOT NULL,
  `progress_status` varchar(40) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE TABLE `test_entities`;
INSERT INTO `test_entities` (`id`, `faculty_id`, `progress_status`, `created_by`, `created_at`, `updated_by`, `updated_at`, `status`) VALUES
(1, '101', 'WF/draft', 101, 1545206983, 101, 1549034920, 10),
(2, '103', 'WF/referral', 103, 1545206983, 3, 1545206983, 10),
(3, '102', 'WF/faculty', 102, 1545206983, 5, 1545206983, 10);


ALTER TABLE `test_entities`
  ADD PRIMARY KEY (`id`);
