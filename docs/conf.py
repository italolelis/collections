import sys, os
from sphinx.highlighting import lexers
from pygments.lexers.web import PhpLexer

lexers['php'] = PhpLexer(startinline=True, linenos=1)
lexers['php-annotations'] = PhpLexer(startinline=True, linenos=1)
primary_domain = 'php'

# -- General configuration -----------------------------------------------------

extensions = []
templates_path = ['_templates']
source_suffix = '.rst'
master_doc = 'index'

project = u'Collections'
copyright = u'2013, Italo Lelis de Vietro'
version = '1.0.0'
release = '1.0.0'

exclude_patterns = ['_build']

# -- Options for HTML output ---------------------------------------------------

# The name for this set of Sphinx documents.  If None, it defaults to
# "<project> v<release> documentation".
html_title = "Collections documentation"
html_short_title = "collections"

# Add any paths that contain custom static files (such as style sheets) here,
# relative to this directory. They are copied after the builtin static files,
# so a file named "default.css" will overwrite the builtin "default.css".
html_static_path = ['_static']

# Custom sidebar templates, maps document names to template names.
html_sidebars = {
    '**':       ['localtoc.html', 'leftbar.html', 'searchbox.html']
}

# Output file base name for HTML help builder.
htmlhelp_basename = 'Collectionsdoc'


# -- Options for LaTeX output --------------------------------------------------

latex_elements = {}

# Grouping the document tree into LaTeX files. List of tuples
# (source start file, target name, title, author, documentclass [howto/manual]).
latex_documents = [
  ('index', 'italolelis.tex', u'Collections Documentation',
   u'Italo Lelis de Vietro', 'manual'),
]

# -- Options for manual page output --------------------------------------------

# One entry per manual page. List of tuples
# (source start file, name, description, authors, manual section).
man_pages = [
    ('index', 'umbrella', u'Collections Documentation',
     [u'Italo Lelis de Vietro'], 1)
]

# If true, show URL addresses after external links.
#man_show_urls = False

# -- Options for Texinfo output ------------------------------------------------

# Grouping the document tree into Texinfo files. List of tuples
# (source start file, target name, title, author,
#  dir menu entry, description, category)
texinfo_documents = [
  ('index', 'Umbrella', u'Collections Documentation',
   u'Italo Lelis de Vietro', 'Umbrella', 'One line description of project.',
   'Miscellaneous'),
]
