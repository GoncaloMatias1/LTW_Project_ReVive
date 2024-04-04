SET @hash_goncalo = PASSWORD('senhaGoncalo');
SET @hash_pedro = PASSWORD('senhaPedro');

INSERT INTO users (name, username, password, email, is_admin) VALUES
('Gonçalo Gonçalves', 'GGgoat', @hash_goncalo, 'goncalogoat@example.com', 0),
('Pedro Flácido', 'PedroDuro', @hash_pedro, 'pedroflacido@example.com', 1);

INSERT INTO categories (name) VALUES
('Roupa')
('Tecnologia')
('Música')
('Automóveis')
('Livros')
('Entretenimento')
('Desporto')

INSERT INTO items (user_id, category_id, title, description, brand, model, size, condition, price) VALUES
(0, 1, 'Camisa preta', 'Camisa preta de algodão', 'Nike', 'Camisa Basic', 'M', 'Como Nova', 19.99),
(1, 2, 'Telemóvel', 'Smartphone com câmera de alta resolução', 'Samsung', 'Galaxy S20', NULL, 'Como Novo', 699.99),
(1, 5, 'Livro', 'Best-seller de ficção científica', 'Arthur C. Clarke', '2001: A Space Odyssey', NULL, 'Usado', 12.50);

