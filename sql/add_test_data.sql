--ForumUser
INSERT INTO ForumUser (username, password, registered) VALUES ('Test', '1234', NOW());
INSERT INTO ForumUser (username, password, registered) VALUES ('Test2', '1234', NOW());

--Thread
INSERT INTO Thread (name, userId, created, lastpost) VALUES ('Test thread', 1, NOW(), NOW());


--Message
INSERT INTO Message (content, userId, threadId, created) VALUES ('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum',
1, 1, NOW());