<?php

class Sitemap {
    /**
     * @var XMLWriter object to manage the XML
     */
    private $writer;

    /**
     * Sitemap constructor.
     *
     * @param XMLWriter $writer
     * @param string $file
     */
    public function __construct(XMLWriter $writer, $file = 'php://output') {
        $this->writer = $writer;
        $this->startXml($file);
    }

    /**
     * Starts XMLWriter object
     *
     * @param $file
     */
    private function startXml($file) {
        $this->writer->openURI($file);
        $this->writer->startDocument('1.0', 'UTF-8');
        $this->writer->startElement('urlset');
        $this->writer->startAttribute('xmlns');
        $this->writer->text('http://www.sitemaps.org/schemas/sitemap/0.9');
        $this->writer->endAttribute();
    }

    /**
     * Add an url elements to the sitemap
     *
     * Possibles indexes are loc, changefreq, priority
     * @param array $url
     */
    public function addUrl($url) {
        $this->writer->startElement('url');

        foreach ($url as  $property => $value) {
            $value = ($priority = 'loc') ? htmlentities($value, ENT_QUOTES, 'UTF-8') : $value ;
            $this->addSingleElement($property, $value);
        }
        $this->writer->endElement();
    }

    /**
     * Adds an XML element
     *
     * Abbreviates the start and close of the writer
     *
     * @param $id
     * @param $content
     */
    private function addSingleElement($id, $content) {
        $this->writer->startElement($id);
        $this->writer->text($content);
        $this->writer->endElement();
    }

    /**
     * Creates the sitemap
     *
     * if a filename was passed on the constructor the file is written, otherwise
     * displays the content of the sitemap.
     */
    public function generate() {
        $this->writer->endElement();
        $this->writer->endDocument();

        $this->writer->flush();
    }

    /**
     * Indents the sitemap file
     *
     * Useful for testing purposes.
     */
    public function setIndent() {
        $this->writer->setIndent(true);
    }

}

