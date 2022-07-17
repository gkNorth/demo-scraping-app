<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class Site {
  public $site_title;
  public $url;
  public $page_titles;
  public $site_links;
  public $page_links;

  // constructor
  public function __construct($site_title, $domain, $path, $parent, $child, $link_type) {

    $client = new Client(HttpClient::create(['verify_peer' => false, 'verify_host' => false]));

    $this->site_title = $site_title;
    $this->domain = $domain;
    $this->path = $path;
    $this->parent = $parent;
    $this->child = $child;
    $this->link_type = $link_type;

    $crawler = $client->request('GET', $domain.$path);

    $titles = $crawler->filter($parent)->each(function ($li) {
      if ($li->filter($this->child)->count()) {
        $title = $li->filter($this->child)->text();
        return $title;
      }
    });

    $links = $crawler->filter($parent)->each(function ($li) {
        if ($li->filter($this->child)->count()) {
          $link = $li->filter($this->child)->attr('href');
          if ($this->link_type == 1) {
            $link = $this->domain.$link;
          }
          return $link;
        }
    });

    $this->page_titles = $titles;
    $this->page_links = $links;
    $this->site_links = $domain.$path;
  }
}

class ScrapingController extends Controller
{
  public function scraping()
  {
      $sites = [
        new Site('Qiita(JS)', 'https://qiita.com/tags/javascript', '', 'article', 'h2 a', 0),
        new Site('Qiita(CSS)', 'https://qiita.com/tags/css', '', 'article', 'h2 a', 0),
        new Site('Qiita(Node.js)', 'https://qiita.com/tags/node.js', '', 'article', 'h2 a', 0),
        new Site('dev.to', 'https://dev.to', '', '.crayons-story', '.crayons-story__title a', 0),
      ];

      return $sites;
  }
}
