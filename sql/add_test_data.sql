--ForumUser
INSERT INTO ForumUser (username, password, userrole, registered) VALUES ('admin', '1234', 'ADMIN', NOW());
INSERT INTO ForumUser (username, password, userrole, registered) VALUES ('testuser', '1234', 'USER', NOW());

--Thread
INSERT INTO Thread (name, user_id, created, lastpost) VALUES ('Test thread', 1, NOW(), NOW());
INSERT INTO Thread (name, user_id, created, lastpost) VALUES ('Second thread', 2, NOW(), NOW());


--Message
INSERT INTO Message (content, user_id, thread_id, created, modified) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
1, 1, NOW(), NOW());
INSERT INTO Message (content, user_id, thread_id, created, modified) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
1, 1, NOW(), NOW());

INSERT INTO thread_user (user_id, thread_id, amount) VALUES (1, 1, 2);

--second thread
INSERT INTO Message (content, user_id, thread_id, created, modified) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
2, 2, NOW(), NOW());
INSERT INTO Message (content, user_id, thread_id, created, modified) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
1, 2, NOW(), to_timestamp('15/10/2100 00:00', 'MM/DD/YYYY HH24:MI'));
INSERT INTO Message (content, user_id, thread_id, created, modified) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
2, 2, NOW(), NOW());

INSERT INTO thread_user (user_id, thread_id, amount) VALUES (2, 2, 2);
INSERT INTO thread_user (user_id, thread_id, amount) VALUES (1, 2, 1);
