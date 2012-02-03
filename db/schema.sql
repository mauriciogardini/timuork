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

CREATE TABLE projects_users (
    id INTEGER PRIMARY KEY ASC,
    project_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE chats (
    id INTEGER PRIMARY KEY ASC,
    project_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE messages (
    id INTEGER PRIMARY KEY ASC,
    text TEXT,
    date_time INTEGER,
    chat_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(chat_id) REFERENCES chats(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE online_users (
    id INTEGER PRIMARY KEY ASC,
    user_id INTEGER,
    chat_id INTEGER,
    last_seen_at INTEGER,
    FOREIGN KEY(chat_id) REFERENCES chats(id),
    FOREIGN KEY(user_id) REFERENCES users(id)
);

CREATE TABLE notifications (
    id INTEGER PRIMARY KEY ASC,
    title TEXT,
    description TEXT,
    sender_user_id INTEGER, 
    project_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id)
);

CREATE TABLE notifications_users (
    id INTEGER PRIMARY KEY ASC,
    notification_id INTEGER,
    user_id INTEGER,
    FOREIGN KEY(user_id) REFERENCES users(id)
    FOREIGN KEY(notification_id) REFERENCES notifications(id)
);

CREATE TABLE links (
    id INTEGER PRIMARY KEY ASC,
    caption TEXT,
    url TEXT,
    project_id INTEGER,
    FOREIGN KEY(project_id) REFERENCES projects(id)
);
