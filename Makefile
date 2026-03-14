.DEFAULT_GOAL=help
GROUPS=all
DOCKER_COMPOSE = docker compose
COMMAND := $(firstword $(MAKECMDGOALS))
#ARGUMENTS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
ARGUMENTS := $(filter-out --,$(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS)))


help:
	@echo $(ARGUMENTS)

%::
	@true

### PATH
REALPATH_EXIST := $(shell which realpath > /dev/null 2>&1; echo $$?)
ifeq ($(REALPATH_EXIST), 0)
	REALPATH = realpath
else
	REALPATH = grealpath
endif

# Get relative path
MAKEFILE_PATH := $(abspath $(lastword $(MAKEFILE_LIST)))
WORKSPACE_DIR := $(patsubst %/,%,$(dir $(MAKEFILE_PATH)))/..
CURRENT_DIR := $(patsubst %/,%,$(dir $(MAKEFILE_PATH)))
RELATIVE_DIR := $(shell $(REALPATH) --relative-to $(WORKSPACE_DIR) $(CURRENT_DIR))

### GIT

$(eval LAST_COMMIT = $(shell git log -1 --oneline --pretty=format:"%h - %an, %ar"))
$(eval LAST_RELEASE = $(shell git describe --abbrev=0 --tags 2>/dev/null || echo "No tags yet"))

#help:
#	@printf ""
#	@printf "                              \033[1;34m Api All in one \033[0m\n"
#	@printf "                           \033[1;34m -------------------- \033[0m\n"
#	@printf ""
#	@grep -E '^[-a-z\:\\]+:.*?## .*$$|^##' $(MAKEFILE_LIST) | \
#	   awk 'BEGIN {FS = ": .*?## "}; {gsub(/\\/, "", $$1); printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | \
#	   sed -e 's/\[32m##/[33m/'
#	@printf ""
#	@printf "Last release: \033[32m$(LAST_RELEASE)\033[0m\n"
#	@printf "Last commit : \033[32m$(LAST_COMMIT)\033[0m\n"
#	@printf ""
#

##
##                                Setup
##---------------------------------------------------------------------------
##

docker\:composer: ## permet d installe les packages
	@docker exec -w /app/$(RELATIVE_DIR) yg_php composer $(ARGS)
	@sudo chown -R $(USER):$(USER) ../$(RELATIVE_DIR)

docker\:console: ## permet d installe les packages
	@docker exec yg_php /app/$(RELATIVE_DIR)/bin/console $(ARGUMENTS)
	@sudo chown -R $(USER):$(USER) ../$(RELATIVE_DIR)

docker\:attach: ## Open a bash in your current terminal to execute command in docker
	@docker exec -it -w /app/$(RELATIVE_DIR) yg_php sh

docker\:exec: ## Launch the command in c variable in the binded repository
	@docker exec -it -w /app/$(RELATIVE_DIR) yg_php sh -c '$(c)'

# exec: ## Install SSL certificate in system trust store
# 	@docker exec -it yg_php sh

composer: ## permet d installe les packages
	@docker exec yg_php composer --working-dir=/app/$(RELATIVE_DIR) $(ARGUMENTS)
	@sudo chown -R smartHulk:smartHulk ../$(RELATIVE_DIR)

console:
	@docker exec yg_php /app/$(RELATIVE_DIR)/bin/console $(ARGUMENTS)
	@sudo chown -R smartHulk:smartHulk ../$(RELATIVE_DIR)

attach: # Open a bash in your current terminal to execute command in docker
	@docker exec -it -w /app/$(RELATIVE_DIR) yg_php bash

exec: # Launch the command in c variable in the binded repository
	@docker exec -it -w /app/$(RELATIVE_DIR) yg_php bash -c '$(c)'

##
##                                Launch
##---------------------------------------------------------------------------
##

start: up ## Start the stack

stop: down ## Stop the stack

up: ## Start containers
	@$(DOCKER_COMPOSE) up -d --build

down: ## Stop containers
	@$(DOCKER_COMPOSE) down --remove-orphans

test:  ## Run tests
	echo "Run tests here "$(SERVICE)

