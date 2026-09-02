# syntax=docker/dockerfile:1.7

FROM php:8.3-cli-alpine@sha256:afdf8b1fee58486ccc0dab5f30f634b86873d56dac985f71ba217945647c05ad AS base
WORKDIR /app
COPY --from=composer:2@sha256:8fa35f42911ff8bbee92aa37d781de6799168d4a0535ac6991f1b250bc2e0245 /usr/bin/composer /usr/bin/composer
COPY composer.json phpunit.xml ./
RUN composer install --no-interaction --prefer-dist
COPY src ./src
COPY tests ./tests

# Composer distribution is VCS-tag based; emit a source tarball for release artifacts.
FROM base AS dist
RUN composer validate --strict
RUN mkdir -p /out && tar -czf /out/sdk-php.tar.gz .

# CI target (use in GitHub Actions)
FROM base AS ci
RUN composer validate --strict
RUN ./tests/run.php
RUN ./vendor/bin/phpunit --configuration phpunit.xml

# Local/development target
FROM base AS dev
CMD ["sh"]
