CREATE DATABASE IF NOT EXISTS escola30setembro;

USE escola30setembro;



CREATE TABLE `candidaturas` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `mensagem` text DEFAULT NULL,
  `status` varchar(45) DEFAULT 'Não Aprovado',
  `data_candidatura` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


ALTER TABLE `candidaturas`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `candidaturas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

