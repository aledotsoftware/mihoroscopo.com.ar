## 2026-02-21 - [Ineffective Keyword Replacement]
**Learning:** The `ArticleController::applyReplacements` method splits text by whitespace, making it impossible to match multi-word keywords (like "Carta Astral") defined in the replacements list.
**Action:** When implementing or optimizing text replacement logic, ensure tokenization strategy supports multi-word phrases (e.g., using `str_replace` arrays or regex with `\b` boundaries instead of splitting by space).

## 2026-02-21 - [Controller Constructor Optimization]
**Learning:** `ArticleController` was building a complex regex in `__construct` on every request, even for methods that didn't use it (e.g., `show`, `admin`).
**Action:** Use lazy initialization for expensive operations in controllers, especially if they are only needed for specific actions.

## 2026-03-01 - [Memory Exhaustion on Large Datasets]
**Learning:** Commands fetching entire database tables via `->get()` (like in `UpdateSubscriptions.php`) cause OOM exceptions as the system scales and table size grows.
**Action:** Always use chunking mechanisms like `->chunk()` or `->chunkById()` when iterating over large datasets in batch processes or CLI commands.

## 2026-03-02 - [Missing Indexes on Heavily Queried Columns]
**Learning:** The `subscriptions` table is frequently queried by `email`, `external_reference`, and `subscription_id` in various critical paths (like `SubscriptionController` and `NotificationController`), but these columns lacked database indexes, leading to full table scans.
**Action:** Always verify that columns used in `where()` clauses or join conditions for large or frequently accessed tables have appropriate database indexes created via migrations.
