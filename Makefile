# Build a distributable theme zip in wp-content (sibling of themes/).
# Excludes: .git, node_modules, bower_components, .DS_Store, and *.md except $(THEME_SLUG)/README.md (optional)
THEME_SLUG := brimstone-hill-ag
PARENT_DIR := $(CURDIR)/..
ZIP_OUT := $(CURDIR)/../../$(THEME_SLUG).zip

.PHONY: zip
zip:
	@tmp=$$(mktemp -t "$(THEME_SLUG).zip.") && \
	trap 'rm -f "$$tmp"' EXIT && \
	(cd "$(PARENT_DIR)" && \
		find "$(THEME_SLUG)" \( -name .git -o -name node_modules -o -name bower_components \) -prune -o \
			-type f ! -name '.DS_Store' \( ! -iname '*.md' -o -path "$(THEME_SLUG)/README.md" \) -print > "$$tmp") && \
	(cd "$(PARENT_DIR)" && zip -q -r "$(ZIP_OUT)" -@ < "$$tmp") && \
	echo "Created $$(realpath "$(ZIP_OUT)")"
