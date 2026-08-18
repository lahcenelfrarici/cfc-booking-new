<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:hero */
class __TwigTemplate_177033242c292587a33d30f87e2c3df9 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--hero"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:hero"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:hero"));
        yield "<section class=\"relative bg-paper overflow-hidden\">
  <div class=\"absolute top-0 right-0 w-[60%] h-full bg-gradient-to-bl from-[#9F5434]/5 via-white to-transparent pointer-events-none\"></div>
  <div class=\"absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full bg-[#9F5434]/8 blur-3xl pointer-events-none\"></div>

  <div class=\"relative max-w-[1440px] mx-auto px-12 pt-24 pb-32 grid grid-cols-12 gap-16 items-center\">
    <div class=\"col-span-7 pr-8\">
      <h1 class=\"tracking-tight text-neutral-900 leading-none\" style=\"font-size: 92px; font-weight: 600; letter-spacing: -0.04em;\">
        The media hub<br />
        <span class=\"font-serif-accent text-[#0F6E56]\" style=\"font-weight: 400;\">of Africa.</span>
      </h1>

      <p class=\"mt-8 text-neutral-700 leading-relaxed max-w-[560px]\" style=\"font-size: 20px;\">
        A dedicated space in Casablanca for international journalists to create, collaborate and produce.
      </p>

      <p class=\"mt-4 text-neutral-500 leading-relaxed max-w-[560px]\" style=\"font-size: 15px;\">
        Access fully equipped workspaces, meeting rooms and a podcast studio — all in one place.
      </p>

      <div class=\"mt-10 flex items-center gap-4\">
        ";
        // line 21
        yield from $this->load("cfc_media_hub:hero", 21, 1)->unwrap()->yield(CoreExtension::merge($context, ["variant" => "terracotta", "size" => "md", "href" => ($context["spaces_url"] ?? null)]));
        // line 25
        yield "        ";
        yield from $this->load("cfc_media_hub:hero", 25, 2)->unwrap()->yield(CoreExtension::merge($context, ["variant" => "outline-dark", "size" => "md", "href" => ($context["production_url"] ?? null)]));
        // line 28
        yield "      </div>

      <div class=\"mt-10 flex items-center gap-2 text-[13px] text-neutral-500\">
        ";
        // line 31
        yield from $this->load("cfc_media_hub:icon", 31)->unwrap()->yield(CoreExtension::toArray(["name" => "map-pin", "size" => "w-4 h-4 text-[#9F5434]"]));
        // line 32
        yield "        Located in Casablanca Finance City, Main Street – CFC Cube, 2nd Floor
      </div>
    </div>

    <div class=\"col-span-5 relative\">
      ";
        // line 37
        yield from $this->load("cfc_media_hub:booking-widget", 37)->unwrap()->yield(CoreExtension::toArray(["booking_base_url" => ($context["booking_base_url"] ?? null)]));
        // line 38
        yield "
      <div class=\"absolute -bottom-8 -left-10 hidden xl:flex items-center gap-3 bg-white rounded-xl shadow-lg border border-neutral-200/70 p-3 pr-5\">
        <img src=\"https://images.unsplash.com/photo-1761543262131-9d464d0d7426?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&q=80&w=200\" alt=\"Studio in use\" class=\"w-12 h-12 rounded-lg object-cover\" />
        <div class=\"leading-tight\">
          <div class=\"text-[12px] text-neutral-500\">The Latest Podcast</div>
          <div class=\"text-[13px] text-neutral-900 font-semibold\">Reuters &middot; Africa Brief</div>
        </div>
      </div>
    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["spaces_url", "production_url", "booking_base_url"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:hero";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  90 => 38,  88 => 37,  81 => 32,  79 => 31,  74 => 28,  71 => 25,  69 => 21,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:hero", "themes/custom/cfc_media_hub/components/hero/hero.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["embed" => 21, "include" => 31];
        static $filters = [];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "embed", 1 => "include"],
                [],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}


/* cfc_media_hub:hero */
class __TwigTemplate_177033242c292587a33d30f87e2c3df9___1 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'label' => [$this, 'block_label'],
            'icon' => [$this, 'block_icon'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 21
        return "cfc_media_hub:button";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--hero"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:hero"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:hero"));
        // line 21
        $this->parent = $this->load("cfc_media_hub:button", 21);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 22
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_label(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Explore the Hub";
        yield from [];
    }

    // line 23
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_icon(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from $this->load("cfc_media_hub:icon", 23)->unwrap()->yield(CoreExtension::toArray(["name" => "arrow-right", "size" => "w-4 h-4"]));
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:hero";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  229 => 23,  218 => 22,  213 => 21,  209 => 1,  202 => 21,  90 => 38,  88 => 37,  81 => 32,  79 => 31,  74 => 28,  71 => 25,  69 => 21,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:hero", "themes/custom/cfc_media_hub/components/hero/hero.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["extends" => 21, "include" => 23];
        static $filters = [];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "extends", 1 => "include"],
                [],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}


/* cfc_media_hub:hero */
class __TwigTemplate_177033242c292587a33d30f87e2c3df9___2 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'label' => [$this, 'block_label'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 25
        return "cfc_media_hub:button";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--hero"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:hero"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:hero"));
        // line 25
        $this->parent = $this->load("cfc_media_hub:button", 25);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 26
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_label(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "View productions";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:hero";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  350 => 26,  345 => 25,  341 => 1,  334 => 25,  229 => 23,  218 => 22,  213 => 21,  209 => 1,  202 => 21,  90 => 38,  88 => 37,  81 => 32,  79 => 31,  74 => 28,  71 => 25,  69 => 21,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:hero", "themes/custom/cfc_media_hub/components/hero/hero.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["extends" => 25];
        static $filters = [];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "extends"],
                [],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
