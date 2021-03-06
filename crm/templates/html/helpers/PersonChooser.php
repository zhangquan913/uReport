<?php
/**
 * Renders the form fields for choosing a person
 *
 * Since we want to always choose an existing person record, or add a
 * person to the system, all person_id input fields should be the same.
 *
 * This form will render HTML for a link to the person choosing process.
 * Once the user has selected the person from the system, the person choosing
 * process will return to the current URL, including |person_id=xxx| in the URL.
 *
 * Progressive Enhancement notes:
 * If the user does not have javascript, the process should still work using
 * page redirection to the href provided.  The people search will return the user
 * to the current url once they've chosen a person.
 *
 * @copyright 2013 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE.txt
 * @author Cliff Ingham <inghamn@bloomington.in.gov>
 */
class PersonChooser
{
	private $template;

	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	/**
	 * @param string $fieldname The name of the person field
	 * @param Person $person The currently selected Person object
	 * @return string
	 */
	public function personChooser($fieldname, Person $person=null)
	{
		$this->template->addToAsset('scripts',YUI.'/yui/yui-min.js');
		$this->template->addToAsset('scripts',BASE_URI.'/js/people/personChooser.js');

		$id   = '';
		$name = '';
		if ($person) {
			$id   = $person->getId();
			$name = View::escape($person->getFullname());
		}
		$return_url = new URL($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		$personChooser = BASE_URI.'/people?return_url='.$return_url;

		$html = "
		<input type=\"hidden\" name=\"{$fieldname}_id\" id=\"{$fieldname}_id\" value=\"$id\" />
		<span id=\"{$fieldname}-name\">$name</span>
		<a class=\"btn\"
			href=\"$personChooser\"
			onclick=\"PERSON_CHOOSER.open('$fieldname');return false;\">
			<span class=\"icon-user\"></span>
			Change Person
		</a>
		";
		return $html;
	}
}