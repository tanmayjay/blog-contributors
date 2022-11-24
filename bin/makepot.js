const wpPot = require('wp-pot');

wpPot({
  destFile: 'languages/jblog-contributors.pot',
  domain: 'jblog-contributors',
  package: 'Blog Contributors',
});
