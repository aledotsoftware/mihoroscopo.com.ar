## 2026-02-21 - [Ineffective Keyword Replacement]
**Learning:** The `ArticleController::applyReplacements` method splits text by whitespace, making it impossible to match multi-word keywords (like "Carta Astral") defined in the replacements list.
**Action:** When implementing or optimizing text replacement logic, ensure tokenization strategy supports multi-word phrases (e.g., using `str_replace` arrays or regex with `\b` boundaries instead of splitting by space).

## 2026-02-21 - [Controller Constructor Optimization]
**Learning:** `ArticleController` was building a complex regex in `__construct` on every request, even for methods that didn't use it (e.g., `show`, `admin`).
**Action:** Use lazy initialization for expensive operations in controllers, especially if they are only needed for specific actions.
