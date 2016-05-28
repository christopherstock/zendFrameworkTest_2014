--
-- Man kann damit beginnen die Datenbank zu befüllen, indem die folgenden SQL
-- Anweisungen ausgeführt werden.
 
INSERT INTO guestbook( email, comment, created ) VALUES
(
    'ralph.schindler@zend.com',
    'Hallo! Hoffentlich geniesst Ihr dieses Beispiel einer ZF Anwendung!',
    DATETIME( 'NOW' ) 
);

INSERT INTO guestbook ( email, comment, created ) VALUES
(
    'foo@bar.com',
    'Baz baz baz, baz baz Baz baz baz - baz baz baz.',
    DATETIME( 'NOW' )
);
    