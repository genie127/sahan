<?php
/**
 * 앱 설정 화면 동적 섹션 API
 *
 * 앱의 설정(explore) 화면에서 표시할 섹션과 링크 목록을 JSON으로 반환합니다.
 * 이 파일만 수정하면 앱 재빌드 없이 항목·링크를 추가/수정/삭제할 수 있습니다.
 *
 * 응답 형식:
 * [
 *   {
 *     "id":            "personal",     // 섹션 고유 ID (앱 캐시 키로 사용, 변경 주의)
 *     "title":         "개인 설정",     // 설정 화면에 표시되는 소제목
 *     "auth_required": true,           // (선택) true면 로그인한 회원에게만 노출
 *     "items": [
 *       {
 *         "id":    "block",          // 항목 고유 ID (변경 주의)
 *         "label": "차단 목록",       // 앱에 표시되는 메뉴명
 *         "url":   "https://..."     // 탭하면 웹뷰로 열리는 URL
 *       }
 *     ]
 *   }
 * ]
 *
 * ─ 주의사항 ──────────────────────────────────────────────────────────────
 * · id 값은 앱이 캐시 식별자로 사용합니다. 한번 배포 후에는 변경하지 마세요.
 * · items가 비어있는 섹션은 앱에서 자동으로 무시됩니다.
 * · URL은 사이트 내부 경로도, 외부 URL도 모두 사용 가능합니다.
 * · auth_required 를 true로 설정하면 로그인한 회원에게만 해당 섹션이 표시됩니다.
 *   (생략하면 false로 간주하여 모든 사용자에게 표시)
 * ──────────────────────────────────────────────────────────────────────────
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Access-Control-Allow-Origin: *');

$base = 'https://sahan.dothome.co.kr';

$sections = [
    [
        'id'            => 'personal',
        'title'         => '개인 설정',
        'auth_required' => true,   // ← 로그인한 회원에게만 노출
        'items'         => [
            [
                'id'    => 'block',
                'label' => '차단 목록',
                'url'   => $base . '/bbs/content.php?co_id=blocked_users',
            ],
        ],
    ],
    [
        'id'    => 'privacy',
        'title' => '이용약관 및 개인정보처리방침',
        'items' => [
            [
                'id'    => 'terms',
                'label' => '이용약관',
                'url'   => $base . '/bbs/content.php?co_id=provision',
            ],
            [
                'id'    => 'privacy',
                'label' => '개인정보처리방침',
                'url'   => $base . '/bbs/content.php?co_id=privacy',
            ],
        ],
    ],
    // ── 섹션 추가 예시 (필요 시 아래 주석 해제 후 수정) ──────────────────
    // [
    //     'id'            => 'community',
    //     'title'         => '커뮤니티',
    //     'auth_required' => false,   // 생략 가능 (모든 사용자에게 노출)
    //     'items'         => [
    //         [
    //             'id'    => 'rules',
    //             'label' => '이용 규칙',
    //             'url'   => $base . '/bbs/content.php?co_id=rules',
    //         ],
    //         [
    //             'id'    => 'faq',
    //             'label' => '자주 묻는 질문',
    //             'url'   => $base . '/bbs/content.php?co_id=faq',
    //         ],
    //     ],
    // ],
];

echo json_encode($sections, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
