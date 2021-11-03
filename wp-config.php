<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'sitegf' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'root' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', '' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'FZ:0;|hLXH9)_Q?S^fYgqRrPdl|i5pqna&Xb/S-E<ZLr|bL4)+*E9~i:z0f]#*V_' );
define( 'SECURE_AUTH_KEY',  'eAoMwH=9ohn|%V2i;/vhsm5Nz?<*S`.CWHC<HA-aui_;%8XWf=WLQX|.<%M4.pvz' );
define( 'LOGGED_IN_KEY',    '!E@PKr6t3M@vD&>q9/k`!;U0U>&dusf#y<Udp^XQC3%1AaV9&!e|IBA1CDBFzN0{' );
define( 'NONCE_KEY',        'fAw<HMt*+$HA+f yIG4Ar6 D3z^2`u`09H`hDYegei9k&a?+)hhx@P#kzQ;/5jXM' );
define( 'AUTH_SALT',        ':Ao~;%wqX -sX5OC9e2L5,D>dH)<vELR,rtACIb|9{xXGOUL#?8(Ko=%!C_txj5{' );
define( 'SECURE_AUTH_SALT', 'uS{CTRjl}L=f]O`A;g10bAhu8>UZ8<E9vf%oK6:Dd9%``pD&#R|_:[{my5INJ9rT' );
define( 'LOGGED_IN_SALT',   'uNm9j-MZ?;zLqvIs-g4&,_ ue;YESgMVQ4NO L[>dyX/Xtk!|_yi`r3ti=G+aca5' );
define( 'NONCE_SALT',       '{3[Q37Q::HCW3^Hz~A/A6dbgy}t#~f2rt9zjAH^XDg}( 7,u|W(%p@yj*/Gu_rkp' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
