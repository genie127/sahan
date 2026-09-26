-- ============================================================
-- 푸시 알림용 디바이스 토큰 저장 테이블
-- 실서버 DB에서 한 번만 실행하면 됨
-- ============================================================

CREATE TABLE IF NOT EXISTS `g5_device_tokens` (
  `dt_id`         INT(11)       NOT NULL AUTO_INCREMENT,
  `dt_token`      VARCHAR(255)  NOT NULL COMMENT 'Expo 푸시 토큰',
  `dt_platform`   VARCHAR(10)   NOT NULL DEFAULT '' COMMENT 'ios / android',
  `dt_mb_id`      VARCHAR(20)   NOT NULL DEFAULT '' COMMENT '로그인 회원 ID (비회원은 빈값)',
  `dt_device_id`  VARCHAR(255)  NOT NULL DEFAULT '' COMMENT '디바이스 고유 ID (중복 방지용)',
  `dt_created_at` DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dt_updated_at` DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`dt_id`),
  UNIQUE KEY `uq_device_id` (`dt_device_id`),
  KEY `idx_token` (`dt_token`(191))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='앱 푸시 디바이스 토큰';
