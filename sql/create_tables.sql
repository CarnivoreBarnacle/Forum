create TABLE ForumUser(
    id SERIAL PRIMARY KEY,
    userrole varchar(5) NOT NULL,
    username varchar(20) NOT NULL,
    password varchar(20) NOT NULL,
    registered DATE
);

create TABLE Thread(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES ForumUser(id),
    name varchar(100) NOT NULL,
    created TIMESTAMP,
    lastpost TIMESTAMP
);

create TABLE Message(
    id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES ForumUser(id),
    thread_id INTEGER REFERENCES Thread(id),
    content varchar(2000) NOT NULL,
    created TIMESTAMP,
    modified TIMESTAMP
);


create TABLE thread_user(
    user_id INTEGER NOT NULL,
    thread_id INTEGER NOT NULL,
    amount INTEGER NOT NULL,
    CONSTRAINT thread_user_pk PRIMARY KEY (user_id, thread_id)
);

