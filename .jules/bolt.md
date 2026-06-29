## 2024-06-29 - Array map vs Switch statement
**Learning:** In high-throughput webhook processing paths (like Mercado Pago notifications), string-based `switch` statements used for simple key-value lookups (e.g., matching currency codes to flags) introduce unnecessary O(N) evaluation complexity.
**Action:** Replace these with static array maps (`static $map = [...]; return $map[$key] ?? $default;`) to achieve O(1) constant-time lookup. This saves CPU cycles per request and significantly improves code readability, which is critical for endpoints facing bursts of external API traffic.
