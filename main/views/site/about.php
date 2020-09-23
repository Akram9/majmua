<?php

use app\assets\DefaultAsset;

DefaultAsset::register($this);

$this->title = 'About Majmua';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <h1>About <span class="green">Majmua</span></h1>

    <p class="about-para">
        &emsp;
        Majmua is a search engine focused on serving content from only a handful of websites.
        Unlike most others, Majmua's aims lie in searching through reliable Islamic websites.
        It is not a competitor or alternative to other search engines.
        <br><br>&emsp;
        Majmua is an Arabic term meaning collection.
        Initially, Majmua started as a collection of websites that teach Islam in the original,
        traditional way.
        As the list of such websites grew, the problem of searching through them arised.
        Majmua, the serch engine, was created to solve this problem.
    </p>
    <br>

    <h3><span class="green">Criteria</span> for being Reliable and Trustable</h3>

    <p class="about-para">
        &emsp;
        Any source that goes against the Quran or Hadith are not reliable.
        Surprisingly, there are way too many sources as such available on the internet.
        Also, Majmua excludes those websites that may have doubtful claims like the need to
        'reinterpret the Quran', or that we should 'integrate' corrupted ideologies in the religion.
        Most such websites though, somehow, contradict themselves and get stuck in the first critera
        itself.
        <br><br>&emsp;
        The only way to recognize such sites are to explicitly read through them and scrutinize
        their content.
        But since every website has too much content to read all of it, only some topics, where most
        fail, are examined along with some random articles.
        Yet, it may happen that a source slips through which may be not right.
        For such cases, it is highly recommended to the users, if they detect, to report the source
        using the report button.
    </p>
    <br>

    <h3>The <span class="green">Search Engine</span></h3>

    <p class="about-para">
        &emsp;
        Source code of the search engine Majmua is available on
        <a href="https://github.com/Akram9/majmua" class="green">github</a>.
        This website, majmua.org, is an implementation of the framework.
        This same framework may be used for any other type of search engine as well.
    </p>

    <br>

    <h3>Current <span class="green">Status</span></h3>

    <p class="about-para">
        &emsp;
        Majmua is my first software project that I have worked on till deployment.
        Yet, a lot is to be done for a great experience.
        The most important thing to work on is to improve search quality, and if possible, quantity.
        Also, there are lot of issues and bugs that need to be addressed.
        Support for different languages is also planned.
        In fact, the database already has huge fraction of non-English material.
        Apart from these, both the frontend and backend need a lot of improvements.
    </p>
    <br>

    <h3 class="green">Contribute</h3>
    <p class="about-para">
        &emsp;
        There are many ways that you can contribute to make Majmua better.
        The best way to help would be by using Majmua and reporting erratic articles, media
        and also erratic behaviour.
        If you are a developer and are willing to help with development, head over to
        <a href="https://github.com/Akram9/majmua" class="green">github</a>.
        InshAllah with time, I intend to involve more people and improve Majmua.
        As a sidenote, Majmua is running on only one server currently, which may cause it to be
        slow in different parts of the world.
    </p>
    <br>

    <p class="about-para">
        <strong>
            Assalamualaikum,
            <br>
            Peace be upon you.
        </strong>
        <br><br><br>
    </p>

</div>