create TABLE ForumUser(
    id SERIAL PRIMARY KEY,
    username varchar(20) NOT NULL,
    password varchar(20) NOT NULL,
    registered DATE
);

create TABLE Thread(
    id SERIAL PRIMARY KEY,
    userId INTEGER REFERENCES ForumUser(id),
    name varchar(100) NOT NULL,
    created TIMESTAMP,
    lastPost TIMESTAMP
);

create TABLE Message(
    id SERIAL PRIMARY KEY,
    userId INTEGER REFERENCES ForumUser(id),
    threadId INTEGER REFERENCES Thread(id),
    content varchar(2000) NOT NULL,
    created TIMESTAMP
);