CREATE TABLE users (
    id INTEGER PRIMARY KEY ASC,
    name TEXT,
    email TEXT,
    username TEXT,
    password TEXT,
    password_salt TEXT
);

CREATE TABLE projects (
    id INTEGER PRIMARY KEY ASC,
    name TEXT,
    description TEXT
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
    FOREIGN KEY(project_id) REFERENCES projects(id)
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
