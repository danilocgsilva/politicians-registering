# Traits in CRUD

The traits have the most simple operations common to all CRUD classes.

At general, serveral CRUD classes may have lots of similarities and some duplication as well. But code duplication still may be preferable than *code obscurecence*. For example, you could create a generic `read()` method in trait, just changing the return type in some parameter. BUT THIS IS INTENTIONALLY AVOIDED. In such case, you may replace the return type to a simple string, so in this case the language linter will have problems to know which is the right code output.
