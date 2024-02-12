<?php ob_start() ?>
  <!--MAIN-->
  <main id="about" class="container">
    <div id="banner" class="my-4 d-flex justify-content-center rounded-3">
      <img class="img-fluid my-4 p-3" src="../web/img/logo/logo_l.png" alt="Logo">
    </div>
    <section class="my-5">
      <h1>Who Are We ?</h1>
      <p>We are a passionate group of web developers committed to creating vibrant online communities. Our
        primary mission is to build platforms that connect people through shared interests, providing virtual spaces
        where they can interact, share, and learn from one another.</p>
      <p>We are driven by the idea that technology can be a powerful tool for fostering meaningful
        connections. Instead of merely developing applications, we strive to build online experiences that inspire
        collaboration, discussion, and the exchange of ideas.</p>
      <p>We believe in the importance of human connection and how technology can facilitate it. As a team
        of web application developers, we aim to create digital environments that not only meet practical needs but also
        nurture community and strengthen bonds among people.</p>
      <p>Our vision is to provide an online haven where users find like-minded companions, share their
        passions, and forge lasting connections. Through our dedication to building quality platforms, we hope to
        contribute to the formation of authentic and enriching digital communities.</p>
    </section>
    <article id="libro" class="d-flex gap-1 my-5 rounded">
      <img id="books" class="img-fluid rounded-3 m-4" src="../web/img/about/libros.jfif" alt="libra">
      <div class="m-4">
        <h2 class="text-white fw-semibold">Why books?</h2>
        <p class="text-white">The choice of books as the main theme is based on the unifying power of literature.
          We believe that books have a unique ability to inspire, educate, and spark meaningful conversations. By
          focusing on literature, we aim to create a space where book enthusiasts can share their opinions, discover new
          works, and connect through their love for reading.</p>
      </div>
    </article>
    <article class="d-flex flex-row-reverse gap-1 my-3 rounded-3">
      <div class="m-4 d-none d-md-block">
        <img class="img-fluid" src="../web/img/about/disco.png" alt="">
      </div>
      <div class="m-4">
        <h2 class="text-white fw-semibold">Why music?</h2>
        <p class="text-white">Music is a universal language that transcends cultural and linguistic barriers. By
          including music as another central theme, we aim to provide users with a platform to express their musical
          preferences, discover new artists, and connect with others who share similar tastes. We aspire to create a
          comprehensive experience that combines the richness of literature with the emotionality of music.</p>
      </div>
    </article>
    <section class="my-5">
      <article class="d-flex flex-row-reverse gap-1 my-3 rounded-3">
        <div class="m-4">
          <h2 class="text-white fw-semibold ">Why blue?</h2>
        <blockquote class="text-white">"Good things are associated with blue, like clear days, more
        than singing the blues. Just the word 'blue' in the singular is full of
        optimism and positive connotation to most people."
        - David Carson.</blockquote>
        <p class="text-white">
          In colour psychology, blue represents calmness and serenity. It creates a sense of security and trust in a brand People are 15% more likely to interact with your brand if it's brand colours are blue. The color is also known to inspire loyalty and shows that a brand has confidence in themselves and their products / services.
        </p>
        </div>
      </article>
        <div class="d-flex flex-wrap my-5 justify-content-evenly">
          <div class="card mt-3">
            <div class="light card-header">Light-blue</div>
            <div class="c-body">
              <span class="p-3">#E5EDFF</span><br>
              <span class="p-3">229,237,255</span>
            </div>
          </div>
          <div class="card mt-3">
            <div class="gray card-header">Gray-blue</div>
            <div class="c-body">
              <span class="p-3">#8092A8</span><br>
              <span class="p-3">128,146,168</span>
            </div>
          </div>
          <div class="card mt-3">
            <div class="cloudy card-header text-white">Cloudy-blue</div>
            <div class="c-body">
              <span class="p-3">#657588 </span><br>
              <span class="p-3">101,117,136</span>
            </div>
          </div>
          <div class="card mt-3">
            <div class="midnight card-header text-white">Midnight-blue</div>
            <div class="c-body">
              <span class="p-3">#29303F</span><br>
              <span class="p-3">41,48,63</span>
            </div>
          </div>
          <div class="card mt-3">
            <div class="dark card-header text-white">Dark-blue</div>
            <div class="c-body">
              <span class="p-3">#0D1117</span><br>
              <span class="p-3">13,17,23</span>
            </div>
          </div>
        </div>
    </section>
    <h2>Group Members</h2>
    <div class="d-flex flex-wrap justify-content-evenly mb-5">
      <div class="members card mt-3">
        <div class="card-header text-white">Alexandra S.V</div>
        <div class="card-body">
            <a href="mailto:alexandrasvasilache@gmail.com">E-mail</a><br>
            <a href="https://github.com/Alexandra-SV">GitHub</a>
        </div>
      </div>
      <div class="members card mt-3">
        <div class="card-header text-white">Ferran M.P</div>
        <div class="card-body">
          <a href="mailto:ferran.mascarell.peiro@gmail.com">E-mail</a><br>
          <a href="https://github.com/ferranmascarell">GitHub</a>
        </div>
      </div>
      <div class="members card mt-3">
        <div class="card-header text-white">Ricardo M.D</div>
        <div class="card-body">
          <a href="mailto:ricardomenadiana@gmail.com">E-mail</a><br>
          <a href="https://github.com/rmenadclases">GitHub</a>
        </div>
      </div>
      <div class="members card mt-3">
        <div class="card-header text-white">Alfonso M.D</div>
        <div class="card-body">
          <a href="mailto:marquezdiazalfonso.amd@gmail.com">E-mail</a><br>
          <a href="https://github.com/AlfonsoMarquezDiaz">GitHub</a>
        </div>
      </div>

    </div>
  </main>
  <!--END MAIN-->

  <?php $contenido = ob_get_clean() ?>

<?php include $menu ?>