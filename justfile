default: lint

# continuously runs lint on file change
lint:
    fswatch "src/" "tests/" | xargs -n1 -I{} sh -c "composer run lint"

# continuously runs lint on file change
test:
    composer run test:watch


