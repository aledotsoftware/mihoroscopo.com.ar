## 2024-05-22 - critical-secrets-exposed
**Vulnerability:** Hardcoded Google OAuth client secret, FTP credentials, and full environment variables file (.env.devplayground) committed to the repository.
**Learning:** Developers likely committed these files for convenience or by accident, not realizing they contained critical secrets. The presence of a zip file suggests a manual backup process that bypassed gitignore.
**Prevention:** Add all sensitive files to .gitignore immediately. Use environment variables for all secrets. Regularly scan the repository for secrets.
