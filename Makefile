# Build a distributable theme zip in wp-content (sibling of themes/).
# WordPress expects: brimstone-hill-ag.zip → brimstone-hill-ag/style.css (one folder at zip root).
# Never zip from inside the theme folder (that bundles .git). Use: make zip
THEME_SLUG := brimstone-hill-ag
PARENT_DIR := $(CURDIR)/..
ZIP_OUT := $(CURDIR)/../../$(THEME_SLUG).zip

# zip(1) -x patterns (applied from PARENT_DIR = themes/).
ZIP_XCLUSIONS := \
	-x '$(THEME_SLUG)/.git/*' \
	-x '$(THEME_SLUG)/.git/**/*' \
	-x '$(THEME_SLUG)/*/.git/*' \
	-x '$(THEME_SLUG)/*/.git/**/*' \
	-x '$(THEME_SLUG)/node_modules/*' \
	-x '$(THEME_SLUG)/node_modules/**/*' \
	-x '$(THEME_SLUG)/bower_components/*' \
	-x '$(THEME_SLUG)/bower_components/**/*' \
	-x '*/.DS_Store' \
	-x '*.md' \
	-x '$(THEME_SLUG)/README.md'

.PHONY: zip
zip:
	@rm -f "$(ZIP_OUT)" && \
		(cd "$(PARENT_DIR)" && \
			COPYFILE_DISABLE=1 zip -qr "$(ZIP_OUT)" "$(THEME_SLUG)" $(ZIP_XCLUSIONS)) && \
		if zipinfo -1 "$(ZIP_OUT)" | grep -qE '(^|/)\.git(/|$$)'; then \
			echo "error: .git paths found in $(ZIP_OUT)" >&2; \
			zipinfo -1 "$(ZIP_OUT)" | grep -E '\.git' >&2; \
			exit 1; \
		fi && \
		echo "Created $$(realpath "$(ZIP_OUT)") (no .git)"
