INSERT INTO `sys_users_faculty` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `access_token`,
                                 `name`, `family`, `email`, `status`, `last_visit_time`, `create_time`, `update_time`,
                                 `delete_time`)
VALUES (101, 'استاد یک.استادها', 'kjJFmQjJfnTh0gSXVkKK8_T2m3wjOMYU',
        '$2y$13$r6dNOxN/7S/G7UmgwUZGm.xdQwu2WcLDKFI1FQZxtup3ntLWctGsG', NULL, NULL, 'استاد یک', 'استادهای یک',
        'fac.1@khan.org', 10, 1549034080, 1549034080, 1549034080, NULL),
       (102, 'استاد دو.استادها', 'oeV5Mce2RNTr5JRfG6gX-q7QIfQalKxi',
        '$2y$13$KUlXuSxhhL/iJK3uag7aG..thihuF/HF2QJLZgJdXpkDKJDJqrAkG', NULL, NULL, 'استاد دو', 'استادهای دو',
        'fac.2@khan.org', 10, 1549034121, 1549034121, 1549034121, NULL),
       (103, 'استاد سه.استادها', 'h_louAMriIvOllrnpwJIPLFWLRrsx9o5',
        '$2y$13$gszQXmcIt8zjn1OfCr7jKeiZJ6q/UDslSKSY5jer6ivgwVCdV75Ay', NULL, NULL, 'استاد سه', 'استادهای سه',
        'fac.3@khan.org', 10, 1549034180, 1549034180, 1549034180, NULL);
INSERT INTO `sys_users_staff` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `access_token`,
                               `name`, `family`, `email`, `status`, `last_visit_time`, `create_time`, `update_time`,
                               `delete_time`)
VALUES (3, 'کارشناس یک.کارشناسها', 'Rl-RyJPhAKUG_0ddO1AW-szqoVV3CBfN',
        '$2y$13$BhZ6jFThSi8U5dJtPAu/Y.kVuaOiFNYd2NyMDFjYR4i55dnQBePY6', NULL, NULL, 'کارشناس یک', 'کارشناسهای یک',
        'staff.1@khan.org', 10, 1549034214, 1549034214, 1549034214, NULL),
       (5, 'کارشناس دو.کارشناسها', 'Rl-RyJPhAKUG_0ddO1AW-szqoVV3CBfN',
        '$2y$13$BhZ6jFThSi8U5dJtPAu/Y.kVuaOiFNYd2NyMDFjYR4i55dnQBePY6', NULL, NULL, 'کارشناس دو', 'کارشناسهای دو',
        'staff.2@khan.org', 10, 1549034214, 1549034214, 1549034214, NULL);
