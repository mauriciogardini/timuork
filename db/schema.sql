CREATE TABLE users (
    id INTEGER PRIMARY KEY ASC,
    name TEXT,
    email TEXT,
    username TEXT,
    password TEXT
);

CREATE TABLE notification_accounts (
    id INTEGER PRIMARY KEY ASC, 
    value TEXT, 
    type TEXT, 
    user_id INTEGER,
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE projects (
    id INTEGER PRIMARY KEY ASC,
    title TEXT,
    description TEXT,
    admin_user_id INTEGER
);

CREATE TABLE allowances (
    id INTEGER PRIMARY KEY ASC,
    project_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE messages (
    id INTEGER PRIMARY KEY ASC,
    text TEXT,
    timestamp INTEGER,
    project_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE statuses (
    id INTEGER PRIMARY KEY ASC,
    user_id INTEGER,
    project_id INTEGER,
    last_seen_at INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE notifications (
    id INTEGER PRIMARY KEY ASC,
    title TEXT,
    description TEXT,
    sender_user_id INTEGER, 
    project_id INTEGER,
    FOREIGN KEY(sender_user_id) REFERENCES users(id),
    FOREIGN KEY(project_id) REFERENCES projects(id)
);

CREATE TABLE notifications_users (
    id INTEGER PRIMARY KEY ASC,
    notification_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(notification_id) REFERENCES notifications(id)
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE links (
    id INTEGER PRIMARY KEY ASC,
    caption TEXT,
    url TEXT,
    project_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id)
);

CREATE TABLE twitter_credentials (
    id INTEGER PRIMARY KEY ASC,
    consumer_key TEXT,
    consumer_secret TEXT,
    access_token TEXT,
    access_token_secret TEXT
);

INSERT INTO twitter_credentials VALUES(
    NULL,
    '7Kim2w5pnn2pJPCtPZKxQ', 
    'WIC8OlgRgiGAtHyvVUUquwd3BhtCGMongLChrNqw',
    '471464900-du760eZz5fuORYBRPhbJIFphBzxnQdH8mOyw3m92',
    'pNBZxYtaCPnUyGlu2Ilv74KrXt9hrag7aYvONMbA'
);

