INSERT INTO users (name, username, password, email, is_admin) VALUES
('Gonçalo Gonçalves', 'GGgoat', '$2y$10$j0kNblannc5.geWCrXu1qOD75tgyyPYVsU70NxIxUyoqxu07cVF32', 'goncalogoat@example.com', 0),
('Pedro Flácido', 'PedroDuro', '$2y$10$nmJbYzgrwXeWvxjGB64k8eytSbwl8oAo8TJZWj/Uhhc8HYCiyWmP.', 'pedroflacido@example.com', 1);

INSERT INTO categories (name) VALUES
('Roupa'),
('Tecnologia'),
('Música'),
('Automóveis'),
('Livros'),
('Entretenimento'),
('Desporto');

INSERT INTO items (user_id, category_id, title, description, city, price, image_path) VALUES
(1, 1, 'Camisa preta', 'Camisa preta de algodão','Porto', 19.99, '/path/to/camisa_preta.jpg'),
(2, 2, 'Telemóvel', 'Smartphone com câmera de alta resolução', 'Lisboa', 699.99, '/path/to/telemovel.jpg'),
(2, 5, 'Livro', 'Best-seller de ficção científica', 'Porto', 12.50, '/path/to/livro.jpg');