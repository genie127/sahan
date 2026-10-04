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

## 3단계: cron-job.org 등록 (dothome은 crontab 미지원)

> dothome 공유 호스팅은 crontab을 지원하지 않으므로 외부 크론 서비스를 사용합니다.

1. [cron-job.org](https://cron-job.org) 무료 회원가입
2. **Create cronjob** 클릭
3. 설정:
   - **URL**: `https://sahan.dothome.co.kr/push_sahan.php?secret=sahan_push_2026!@#$`
   - **Schedule**: Custom → Month: `10`, Day: `21`, Hour: `0`, Minute: `0`
4. 저장

> **주의:** 발송 스크립트는 `api/push/send_push.php` 가 아닌  
> 루트의 **`push_sahan.php`** 를 사용합니다. (api/push/ 경로는 dothome에서 접근 차단됨)

---

## 수동 테스트 (브라우저에서 바로 확인)

```
https://sahan.dothome.co.kr/push_sahan.php?secret=sahan_push_2026!@#$
```

---

## push_sahan.php 주요 설정 (파일 상단 수정)

```php
define('PUSH_SECRET_KEY', 'sahan_push_2026!@#$'); // cron-job.org URL의 secret 값과 동일하게
$push_title = '사한절';                            // 푸시 제목
$push_body  = 'Happy Birthday To 희건, 사한';      // 푸시 내용
```
