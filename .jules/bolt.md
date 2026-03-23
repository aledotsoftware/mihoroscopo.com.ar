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

## 2026-03-05 - [Eloquent Model Hydration Overhead]
**Learning:** Replacing a raw `DB::table()->join()` with Eloquent ORM `Subscription::with(...)` for retrieving a single record creates a significant performance degradation. Model hydration uses much more CPU and memory, and eager loading executes multiple separate queries instead of a fast, single SQL `JOIN`.
**Action:** When optimizing performance-critical paths, especially for fetching single records or read-only structured data, prefer raw `DB::table()` with `JOIN` over Eloquent relationship eager-loading (`with`).

## 2026-03-06 - [Model Hydration Overhead in Index Views]
**Learning:** Eloquent `Model::paginate()` retrieves all columns by default. When the table contains heavy columns (like large Markdown/HTML text in the `articles.content` column), hydrating these fields into memory for index views that only display titles/slugs causes significant memory and CPU waste per request.
**Action:** Always explicitly use `select()` in queries intended for index/list views to restrict the returned columns to only what is necessary (e.g., `id`, `slug`, `title`, `created_at`), preventing the expensive loading of large text or BLOB columns.

## 2026-03-10 - [Eloquent Model Hydration Overhead on Simple Updates]
**Learning:** In highly concurrent endpoints (like an email tracking pixel handler `trackOpen`), using `Model::find($id)` followed by `$model->update()` incurs the cost of executing a `SELECT` query and hydrating a full Eloquent model into memory, just to update a single timestamp.
**Action:** When updating a single database column without needing model lifecycle events, prefer direct mass update queries (e.g., `Model::where('id', $id)->update(...)`) to eliminate unnecessary SELECT queries and the memory/CPU overhead of Eloquent model hydration.

## 2026-03-10 - [Memory Overhead of file_get_contents]
**Learning:** Serving a static file by reading it entirely into memory with `file_get_contents()` and then wrapping it in a `Response::make()` causes significant memory spikes and potential Out-Of-Memory (OOM) errors under high concurrency (e.g., serving a tracking pixel).
**Action:** When serving static files or binaries from controllers, always use Laravel's streaming helpers like `response()->file($path)` or `response()->download($path)` to stream the file directly from disk. This drastically reduces peak memory usage and automatically leverages HTTP caching headers like `Last-Modified` and `ETag`.

## 2026-03-11 - [Eloquent Model Hydration Overhead in Batch Jobs]
**Learning:** In batch commands like `UpdateSubscriptions`, loading full Eloquent models using `Subscription::chunkById` is inefficient when only needing specific IDs to call an external API and perform updates. Hydrating the models and fetching heavy JSON columns (`response`, `payload`) from the database causes massive CPU spikes and slows down the command throughput.
**Action:** When updating millions of rows in a background job where you only need a few columns (e.g., `id`, `subscription_id`), use `DB::table()->select()->chunkById()` to fetch only necessary fields as arrays/objects, and use `DB::table()->where()->update()` for mass updates to bypass Eloquent memory and CPU overhead.

## 2026-03-14 - [Eloquent Model Hydration Overhead on Inserts]
**Learning:** In batch commands processing thousands of records (e.g., `SendDailyContentEmails`) or high-throughput endpoints (e.g., `EmailTrackingController`), using `Model::create()` within the loop forces Eloquent to instantiate a full Model object for every iteration. This wastes memory and CPU on model hydration for objects that are immediately discarded or only needed for their ID.
**Action:** When inserting records in loops or high-throughput paths where the full Eloquent model object isn't needed, prefer raw `DB::table()->insert()` (or `insertGetId()` if the generated ID is required). This bypasses the Eloquent lifecycle events and hydration, drastically reducing CPU time and memory footprint. Note: When replacing `Model::create()` with `DB::table()->insert()`, you must explicitly add `created_at` and `updated_at` timestamps to the array if the table expects them, as Eloquent's automatic timestamp management is bypassed.

## 2026-03-18 - [Eloquent Model Hydration Overhead in Chunking Queries]
**Learning:** When using `Model::chunk()` or `Model::chunkById()` for batch processes (e.g., `SendDailyContentEmails`), Eloquent fetches all columns by default. If the table contains heavy TEXT/JSON columns (like `response` or `payload`), hydrating these into memory for thousands of records per chunk causes significant RAM usage and network I/O overhead.
**Action:** Always use `select()` in Eloquent chunking queries to explicitly restrict the fetched columns to only those required by the loop logic, preventing unnecessary memory allocation.

## 2026-03-23 - [Blocking Webhooks]
**Learning:** Webhook handlers (like `NotificationController::toQueue`) often receive high traffic and need to respond to the provider (like MercadoPago or dLocalGo) immediately to prevent timeouts and retries. Processing synchronous HTTP requests (`curl`), database transactions, or sending Discord logs inside the main web request cycle creates a severe bottleneck.
**Action:** In Laravel 11.x applications, optimize synchronous webhook handlers by wrapping blocking operations inside the `defer()` helper (e.g., `defer(fn () => $this->handle($data));`). This acknowledges the webhook instantly with a 200 OK and executes the heavy logic in the background, significantly reducing response time and preventing external provider timeouts.
