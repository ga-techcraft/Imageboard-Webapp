# 設計書：画像掲示板アプリ（Image Board App）

---

### 1. 機能一覧

| ID | 機能名 | 説明 |
| --- | --- | --- |
| F-1 | スレッド作成 | 画像＋テキスト投稿で新スレッドを作成 |
| F-2 | スレッド一覧表示 | メインスレッドの一覧と最新5件の返信表示 |
| F-3 | スレッド詳細表示 | スレッドクリックで全返信表示 |
| F-4 | スレッドに返信 | 画像あり/なしの返信投稿が可能 |
| F-5 | 画像アップロード | 画像はハッシュ付きファイル名で保存される |
| F-6 | サムネイル生成 | 画像にサムネイルを生成し、表示に使用 |
| F-7 | フル画像取得 | サムネイルクリックでフルサイズ画像を表示 |

---

### 2. データベース設計（ER図・テーブル定義）

### posts テーブル

| カラム名 | 型 | 説明 |
| --- | --- | --- |
| id | BIGINT | 主キー、自動採番 |
| reply_to_id | BIGINT | 自己参照（nullならメインスレッド） |
| subject | VARCHAR(20) | 件名（任意） |
| content | VARCHAR(200) | 投稿本文 |
| image_path | VARCHAR(50) | 画像の保存パス |
| created_at | DATETIME | 作成日時 |
 

---

### 3. URL設計

| ページ名 | URL | メソッド | 説明 |
| --- | --- | --- | --- |
| トップページ | /posts | GET | スレッド一覧＋最新5件返信表示 |
| 新規投稿 | `/posts/{id}` | POST | スレッド作成処理 |
| スレッド詳細 | `/posts/{id}` | GET | スレッド詳細と返信表示 |
| 返信投稿 | `/posts/{id}/replies` | POST | 指定postへの返信投稿 |
| フル画像 | /images/full/{filename}.~~ | GET | フルサイズ画像表示 |

---

### 4. クラス設計

```php
php
CopyEdit
class PostDAO {
    public function create(Post $post): bool;
    public function findById(int $id): ?Post;
    public function findAllMainThreads(): array;
    public function findRepliesByPostId(int $postId): array;
}

```

---

### 5. 画像保存仕様

- **保存ディレクトリ**： `/storage/images/`
- **ファイル名ルール**： `sha256(post_id + created_at + rand) . 拡張子`
- **サムネイル命名**： `{hash}_thumb.jpg`
- **コマンド例**：
    
    ```bash
    bash
    CopyEdit
    convert input.jpg -resize 150x150! output_thumb.jpg
    
    ```
    

---

### 6. バリデーション仕様
| 項目 | ルール例 |
| --- | --- |
| 画像サイズ | 5MB以内 |
| 画像形式 | jpg / png / gif のみ |
| 件名 | 20文字以内 |
| 本文 | 200文字以内 |
| 返信先ID | 存在するpost_idかnull |