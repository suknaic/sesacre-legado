<?php

$senha = $argv[1] ?? '123456';
$hash = password_hash($senha, PASSWORD_DEFAULT, ['cost' => 14]);

echo "-- Hash gerado em " . date('Y-m-d H:i:s') . "\n";
echo "-- Senha: {$senha}\n";
echo "\n";
echo "-- Para colocar no seed.sql:\n";
echo "INSERT INTO ses_pessoa (id_pessoa, nm_pessoa, nm_email, nm_senha, st_ativo)\n";
echo "VALUES (1, 'Administrador', 'admin@ac.gov.br', '{$hash}', 1);\n";
echo "\n";
echo "-- Ou atualizar direto no banco:\n";
echo "UPDATE ses_pessoa SET nm_senha = '{$hash}' WHERE id_pessoa = 1;\n";
