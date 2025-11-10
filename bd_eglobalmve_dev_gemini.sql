/*
 Navicat Premium Data Transfer

 Source Server         : Dev4
 Source Server Type    : MySQL
 Source Server Version : 50731
 Source Host           : localhost:3306
 Source Schema         : bd_eglobalmve_dev

 Target Server Type    : MySQL
 Target Server Version : 50731
 File Encoding         : 65001

 Date: 07/11/2025 18:12:24
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;


-- ----------------------------
-- Table structure for cove_decrementable
-- ----------------------------
DROP TABLE IF EXISTS `cove_decrementable`;
CREATE TABLE `cove_decrementable`  (
  `id_decrementable` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cove` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_decrementable` int(10) UNSIGNED NOT NULL,
  `fecha_erogacion` date NULL DEFAULT NULL,
  `importe` decimal(18, 4) NULL DEFAULT NULL,
  `cve_moneda` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `tipo_cambio` decimal(10, 6) NULL DEFAULT NULL,
  PRIMARY KEY (`id_decrementable`) USING BTREE,
  INDEX `idx_id_cove_dec`(`id_cove`) USING BTREE,
  INDEX `fk_id_tipo_decrementable`(`id_tipo_decrementable`) USING BTREE,
  CONSTRAINT `fk_covedec_cove` FOREIGN KEY (`id_cove`) REFERENCES `mve_cove` (`id_cove`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_covedec_tipo` FOREIGN KEY (`id_tipo_decrementable`) REFERENCES `ct_decrementable` (`id_decrementable_catalogo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cove_incrementable
-- ----------------------------
DROP TABLE IF EXISTS `cove_incrementable`;
CREATE TABLE `cove_incrementable`  (
  `id_incrementable` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cove` bigint(20) UNSIGNED NOT NULL,
  `id_tipo_incrementable` int(10) UNSIGNED NOT NULL,
  `fecha_erogacion` date NULL DEFAULT NULL,
  `importe` decimal(18, 4) NULL DEFAULT NULL,
  `cve_moneda` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `tipo_cambio` decimal(10, 6) NULL DEFAULT NULL,
  `a_cargo_importador` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_incrementable`) USING BTREE,
  INDEX `idx_id_cove_inc`(`id_cove`) USING BTREE,
  INDEX `fk_id_tipo_incrementable`(`id_tipo_incrementable`) USING BTREE,
  CONSTRAINT `fk_coveinc_cove` FOREIGN KEY (`id_cove`) REFERENCES `mve_cove` (`id_cove`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_coveinc_tipo` FOREIGN KEY (`id_tipo_incrementable`) REFERENCES `ct_incrementable` (`id_incrementable_catalogo`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cove_precio_pagado
-- ----------------------------
DROP TABLE IF EXISTS `cove_precio_pagado`;
CREATE TABLE `cove_precio_pagado`  (
  `id_precio_pagado` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cove` bigint(20) UNSIGNED NOT NULL,
  `id_forma_pago` int(10) UNSIGNED NOT NULL,
  `idmve` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'Campo de la estructura original, si no es usado, se puede quitar',
  `fecha_pago` date NULL DEFAULT NULL,
  `importe` decimal(18, 4) NULL DEFAULT NULL,
  `cve_moneda` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `tipo_cambio` decimal(10, 6) NULL DEFAULT NULL,
  `especifique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_precio_pagado`) USING BTREE,
  INDEX `idx_id_cove`(`id_cove`) USING BTREE,
  INDEX `fk_id_forma_pago`(`id_forma_pago`) USING BTREE,
  CONSTRAINT `fk_covepp_cove` FOREIGN KEY (`id_cove`) REFERENCES `mve_cove` (`id_cove`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_covepp_fpago` FOREIGN KEY (`id_forma_pago`) REFERENCES `ct_forma_pago` (`id_forma_pago`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for cove_precio_por_pagar
-- ----------------------------
DROP TABLE IF EXISTS `cove_precio_por_pagar`;
CREATE TABLE `cove_precio_por_pagar`  (
  `id_precio_por_pagar` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cove` bigint(20) UNSIGNED NOT NULL,
  `id_forma_pago` int(10) UNSIGNED NULL DEFAULT NULL,
  `idmve` bigint(20) UNSIGNED NULL DEFAULT NULL COMMENT 'Campo de la estructura original, si no es usado, se puede quitar',
  `fecha_pago` date NULL DEFAULT NULL,
  `importe` decimal(18, 4) NULL DEFAULT NULL,
  `cve_moneda` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `tipo_cambio` decimal(10, 6) NULL DEFAULT NULL,
  `especifique` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `situacion_no_fecha_pago` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_precio_por_pagar`) USING BTREE,
  INDEX `idx_id_cove_ppp`(`id_cove`) USING BTREE,
  INDEX `fk_id_forma_pago_ppp`(`id_forma_pago`) USING BTREE,
  CONSTRAINT `fk_coveppp_cove` FOREIGN KEY (`id_cove`) REFERENCES `mve_cove` (`id_cove`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_coveppp_fpago` FOREIGN KEY (`id_forma_pago`) REFERENCES `ct_forma_pago` (`id_forma_pago`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;





-- ----------------------------
-- Table structure for mve
-- ----------------------------
DROP TABLE IF EXISTS `mve`;
CREATE TABLE `mve`  (
  `idmve` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `edocument_mve` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `fecha_ingreso` date NULL DEFAULT NULL,
  `fecha_respuesta_vucem` datetime NULL DEFAULT NULL,
  `origen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `numero_operacion_mve` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `base_datos_trafico` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `cve_estado_mve` enum('INICIO','PENDIENTE_AA','PENDIENTE_IMPORTADOR','LISTA_VUCEM','VUCEM_ENVIADA','VUCEM_ACEPTADA','VUCEM_RECHAZADA') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL DEFAULT 'INICIO',
  `fecha_visto_bueno_importador` datetime NULL DEFAULT NULL,
  `fecha_visto_bueno_agente` datetime NULL DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `usuario_creacion_id` bigint(20) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`idmve`) USING BTREE,
  INDEX `idx_estado`(`cve_estado_mve`) USING BTREE,
  INDEX `idx_fecha_ingreso_desc`(`fecha_ingreso`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for mve_cove
-- ----------------------------
DROP TABLE IF EXISTS `mve_cove`;
CREATE TABLE `mve_cove`  (
  `id_cove` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idmve` bigint(20) UNSIGNED NOT NULL,
  `id_incoterm` int(10) UNSIGNED NOT NULL,
  `id_metodo_valoracion` int(10) UNSIGNED NOT NULL,
  `cove` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `vinculacion` enum('0','1') CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_cove`) USING BTREE,
  INDEX `idx_idmve`(`idmve`) USING BTREE,
  INDEX `fk_id_incoterm`(`id_incoterm`) USING BTREE,
  INDEX `fk_id_metodo_valoracion`(`id_metodo_valoracion`) USING BTREE,
  CONSTRAINT `fk_mvecove_incoterm` FOREIGN KEY (`id_incoterm`) REFERENCES `ct_incoterm` (`id_incoterm`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_mvecove_metval` FOREIGN KEY (`id_metodo_valoracion`) REFERENCES `ct_metodo_valoracion` (`id_metodo_valoracion`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_mvecove_mve` FOREIGN KEY (`idmve`) REFERENCES `mve` (`idmve`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for mve_datos_generales
-- ----------------------------
DROP TABLE IF EXISTS `mve_datos_generales`;
CREATE TABLE `mve_datos_generales`  (
  `id_datos_generales` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idmve` bigint(20) UNSIGNED NOT NULL,
  `id_cliente` int(10) UNSIGNED NOT NULL,
  `cve_aduana` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `patente` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `pedimento` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `rfc_importador` varchar(13) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_datos_generales`) USING BTREE,
  UNIQUE INDEX `uk_idmve`(`idmve`) USING BTREE,
  INDEX `idx_id_cliente`(`id_cliente`) USING BTREE,
  CONSTRAINT `fk_mve_dg_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `ct_importador` (`id_importador`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_mve_dg_mve` FOREIGN KEY (`idmve`) REFERENCES `mve` (`idmve`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for mve_documento
-- ----------------------------
DROP TABLE IF EXISTS `mve_documento`;
CREATE TABLE `mve_documento`  (
  `id_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idmve` bigint(20) UNSIGNED NOT NULL,
  `edocument` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_documento`) USING BTREE,
  INDEX `idx_idmve_doc`(`idmve`) USING BTREE,
  CONSTRAINT `fk_mve_doc_mve` FOREIGN KEY (`idmve`) REFERENCES `mve` (`idmve`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 12 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for mve_log_cambios
-- ----------------------------
DROP TABLE IF EXISTS `mve_log_cambios`;
CREATE TABLE `mve_log_cambios`  (
  `id_log_cambio` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idmve` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `fecha_cambio` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cve_tipo_cambio` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_tabla` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_campo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  `valor_anterior` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL,
  `valor_nuevo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL,
  PRIMARY KEY (`id_log_cambio`) USING BTREE,
  INDEX `idx_mve_fecha`(`idmve`, `fecha_cambio`) USING BTREE,
  INDEX `idx_usuario_tipo`(`id_usuario`, `cve_tipo_cambio`) USING BTREE,
  CONSTRAINT `fk_log_mve` FOREIGN KEY (`idmve`) REFERENCES `mve` (`idmve`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

-- ----------------------------
-- Table structure for mve_log_documentos
-- ----------------------------
DROP TABLE IF EXISTS `mve_log_documentos`;
CREATE TABLE `mve_log_documentos`  (
  `id_log_documento` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_documento_mve` bigint(20) UNSIGNED NOT NULL,
  `id_usuario` bigint(20) UNSIGNED NOT NULL,
  `fecha_evento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cve_tipo_evento` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `nombre_archivo_orig` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `ruta_archivo_final` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NOT NULL,
  `edocument_vucem` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish2_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_log_documento`) USING BTREE,
  INDEX `idx_doc_evento_fecha`(`id_documento_mve`, `fecha_evento`) USING BTREE,
  INDEX `idx_edocument_vucem`(`edocument_vucem`) USING BTREE,
  CONSTRAINT `fk_logdoc_mvedoc` FOREIGN KEY (`id_documento_mve`) REFERENCES `mve_documento` (`id_documento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;



-- ----------------------------
-- Table structure for mve_valor_aduana
-- ----------------------------
DROP TABLE IF EXISTS `mve_valor_aduana`;
CREATE TABLE `mve_valor_aduana`  (
  `id_valor_aduana` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `idmve` bigint(20) UNSIGNED NOT NULL,
  `total_precio_pagado` decimal(18, 4) NULL DEFAULT NULL,
  `total_precio_por_pagar` decimal(18, 4) NULL DEFAULT NULL,
  `total_incrementables` decimal(18, 4) NULL DEFAULT NULL,
  `total_decrementables` decimal(18, 4) NULL DEFAULT NULL,
  `total_valor_aduana` decimal(18, 4) NULL DEFAULT NULL,
  PRIMARY KEY (`id_valor_aduana`) USING BTREE,
  UNIQUE INDEX `uk_idmve_va`(`idmve`) USING BTREE,
  CONSTRAINT `fk_mveva_mve` FOREIGN KEY (`idmve`) REFERENCES `mve` (`idmve`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 11 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_spanish2_ci ROW_FORMAT = DYNAMIC;

SET FOREIGN_KEY_CHECKS = 1;
