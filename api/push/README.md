# 푸시 알림 서버 연동

## 파일 구성

| 파일 | 역할 |
|------|------|
| `create_table.sql` | DB 테이블 생성 SQL (최초 1회 실행) |
| `register.php` | 앱 → 서버 토큰 등록 API |
| `send_push.php` | 실제 푸시 발송 스크립트 |
| `.htaccess` | send_push.php 외부 접근 차단 |

---

## 1단계: DB 테이블 생성 (최초 1회)

실서버 DB에서 `create_table.sql` 실행:

```sql
-- phpMyAdmin, HeidiSQL, 또는 mysql 클라이언트에서 실행
-- 테이블명: g5_device_tokens (G5_TABLE_PREFIX 기준)
```

---

## 2단계: 앱에서 토큰 등록

앱 실행 시 Expo 푸시 토큰을 아래 엔드포인트로 전송:

```
POST https://yourdomain.com/api/push/register.php
Content-Type: application/json

{
  "token":     "ExponentPushToken[xxxxxx]",
  "platform":  "ios",
  "device_id": "디바이스_고유_UUID"
}
```

**응답 예시:**
```json
{ "success": true, "message": "토큰이 등록되었습니다." }
```

---

## 3단계: 크론잡 등록 (매년 10월 21일 00:00 KST 자동 발송)

실서버 터미널에서 `crontab -e` 실행 후 아래 한 줄 추가:

```cron
0 0 21 10 * /usr/bin/php /var/www/html/api/push/send_push.php >> /var/log/push_send.log 2>&1
```

> **PHP 경로 확인:** `which php` 명령으로 실제 경로 확인 후 수정
> **서버 경로 확인:** 실제 document root 경로로 수정

### 타임존 주의
서버가 UTC라면 KST(+9) 기준 10월 21일 00:00 = UTC 10월 20일 15:00이므로:
```cron
0 15 20 10 * /usr/bin/php /var/www/html/api/push/send_push.php >> /var/log/push_send.log 2>&1
```

서버 타임존은 `date` 명령으로 확인.

---

## 수동 발송 (테스트용)

```bash
php /var/www/html/api/push/send_push.php
php /var/www/html/api/push/send_push.php --title="테스트" --body="내용입니다"
```

---

## send_push.php 주요 설정 (파일 상단 수정)

```php
define('PUSH_SECRET_KEY', 'push_secret_키를_여기에_변경하세요_!@#'); // 웹 호출 시 사용할 시크릿
$push_title = '사한이의 날';                             // 푸시 제목
$push_body  = '오늘은 특별한 날입니다. 앱을 열어보세요!'; // 푸시 내용
```
