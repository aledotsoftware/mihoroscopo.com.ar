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

## 2026-03-04 - [Missing Indexes on Payment Table]
**Learning:** The `payment` table is queried by `payment_id` and `external_reference` in critical paths (like `NotificationController` and `SubscriptionController`), but these columns lacked database indexes, leading to full table scans and performance degradation.
**Action:** Always ensure that columns frequently used in `where()` clauses or join conditions have appropriate database indexes created via migrations, especially for tables that grow rapidly like payments.

## 2026-03-05 - [Missing Index on extradata_horoscopes]
**Learning:** The `extradata_horoscopes` table is heavily queried using `subscription_id` via relationships (like `hasMany`) and joins in performance-critical areas (e.g., `SubscriptionController` and `SendDailyContentEmails`), but lacked an index, causing full table scans.
**Action:** Always index foreign keys and columns that are frequently used in relationship resolution and joins. This is especially critical for batch processes and controllers handling significant traffic.
