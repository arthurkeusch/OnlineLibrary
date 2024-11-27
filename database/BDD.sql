DROP TABLE IF EXISTS Reviews, LoanHistory, WrittenBy, Users, Copies, States, Authors, Books;

CREATE TABLE Books
(
    id_book               INT,
    name_book             VARCHAR(255),
    description_book      TEXT,
    publication_date_book DATE,
    PRIMARY KEY (id_book)
);

CREATE TABLE Authors
(
    id_author   INT,
    name_author VARCHAR(255),
    PRIMARY KEY (id_author)
);

CREATE TABLE States
(
    id_state   INT,
    name_state VARCHAR(32),
    PRIMARY KEY (id_state)
);

CREATE TABLE Copies
(
    id_copy     INT,
    isAvailable BOOLEAN,
    id_book     INT NOT NULL,
    id_state    INT NOT NULL,
    PRIMARY KEY (id_copy),
    FOREIGN KEY (id_book) REFERENCES Books (id_book),
    FOREIGN KEY (id_state) REFERENCES States (id_state)
);

CREATE TABLE Users
(
    id_user         INT,
    username        VARCHAR(255),
    password        TEXT,
    first_name_user VARCHAR(255),
    last_name_user  VARCHAR(255),
    isAdmin         BOOLEAN,
    PRIMARY KEY (id_user)
);

CREATE TABLE WrittenBy
(
    id_book   INT,
    id_author INT,
    PRIMARY KEY (id_book, id_author),
    FOREIGN KEY (id_book) REFERENCES Books (id_book),
    FOREIGN KEY (id_author) REFERENCES Authors (id_author)
);

CREATE TABLE LoanHistory
(
    id_copy    INT,
    id_user    INT,
    start_loan DATE,
    end_loan   DATE,
    PRIMARY KEY (id_copy, id_user),
    FOREIGN KEY (id_copy) REFERENCES Copies (id_copy),
    FOREIGN KEY (id_user) REFERENCES Users (id_user)
);

CREATE TABLE Reviews
(
    id_book        INT,
    id_user        INT,
    content_review TEXT,
    date_review    DATE,
    PRIMARY KEY (id_book, id_user),
    FOREIGN KEY (id_book) REFERENCES Books (id_book),
    FOREIGN KEY (id_user) REFERENCES Users (id_user)
);
