
## 2024-10-25 - Added loading and disabled state to synchronous form
**Learning:** For synchronous form submissions in custom frontend templates (e.g. `payment_form.blade.php`), a dedicated disabled state coupled with `aria-busy="true"` prevents duplicate clicks during backend processing and visually alerts users to wait. Dynamically appending `aria-live="polite"` via DOM scripts upon submission might not be consistently announced by all screen readers compared to an element statically present in the DOM beforehand.
**Action:** When adding accessible loading text dynamically, assure the live region is either already in the DOM or reconsider the timing of the attribute vs innerHTML updates for better screen reader compatibility.
