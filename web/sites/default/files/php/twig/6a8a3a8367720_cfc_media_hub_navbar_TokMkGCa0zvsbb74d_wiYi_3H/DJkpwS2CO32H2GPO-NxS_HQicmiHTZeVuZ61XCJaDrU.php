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

/* cfc_media_hub:navbar */
class __TwigTemplate_a8159f108a3df9381fda68f106067261 extends Template
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
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--navbar"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:navbar"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:navbar"));
        yield "<header class=\"sticky top-0 z-40 w-full bg-white/75 backdrop-blur-xl border-b border-neutral-900/[0.06]\">
  <div class=\"max-w-[1440px] mx-auto px-12 h-28 flex items-center justify-between\">
    <a href=\"";
        // line 3
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["home_url"] ?? null), "html", null, true);
        yield "\" class=\"flex items-center -ml-2\">
      <img src=\"";
        // line 4
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["logo_url"] ?? null), "html", null, true);
        yield "\" alt=\"CFC Media Hub\" class=\"h-20 w-auto\" />
    </a>

    <nav class=\"flex items-center gap-9\">
      ";
        // line 8
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["links"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["link"]) {
            // line 9
            yield "        <a href=\"";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["link"], "url", [], "any", false, false, true, 9), "html", null, true);
            yield "\" class=\"relative flex flex-col items-center gap-1.5 text-[14px] font-";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["link"], "active", [], "any", false, false, true, 9)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("semibold") : ("normal")));
            yield " transition-colors group\">
          <span class=\"";
            // line 10
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar((((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["link"], "active", [], "any", false, false, true, 10)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) ? ("text-[#0F6E56]") : ("text-neutral-700 group-hover:text-[#0F6E56]")));
            yield "\">";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["link"], "label", [], "any", false, false, true, 10), "html", null, true);
            yield "</span>
          ";
            // line 11
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["link"], "active", [], "any", false, false, true, 11)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 12
                yield "            <span class=\"absolute -bottom-2 left-1/2 -translate-x-1/2 w-1.5 h-1.5 rounded-full bg-[#9F5434]\"></span>
          ";
            }
            // line 14
            yield "        </a>
      ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['link'], $context['_parent']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 16
        yield "    </nav>

    <div class=\"flex items-center gap-4\">
      <button type=\"button\" class=\"flex items-center gap-1.5 text-[13px] text-neutral-600 hover:text-neutral-900\">
        ";
        // line 20
        yield from $this->load("cfc_media_hub:icon", 20)->unwrap()->yield(CoreExtension::toArray(["name" => "globe", "size" => "w-4 h-4"]));
        // line 21
        yield "        EN
      </button>

      ";
        // line 24
        if ((($tmp = ($context["is_authenticated"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 25
            yield "        <a href=\"";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["account_url"] ?? null), "html", null, true);
            yield "\" class=\"text-[13px] font-medium text-[#0F6E56] hover:text-[#085041] transition-colors\">My Account</a>
      ";
        } else {
            // line 27
            yield "        <a href=\"";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["sign_in_url"] ?? null), "html", null, true);
            yield "\" class=\"text-[13px] text-neutral-700 hover:text-neutral-900 transition-colors\">Sign in</a>
      ";
        }
        // line 29
        yield "
      ";
        // line 30
        yield from $this->load("cfc_media_hub:navbar", 30, 1)->unwrap()->yield(CoreExtension::merge($context, ["variant" => "terracotta", "size" => "sm", "href" => ($context["booking_url"] ?? null)]));
        // line 33
        yield "    </div>
  </div>
</header>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["home_url", "logo_url", "links", "is_authenticated", "account_url", "sign_in_url", "booking_url"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:navbar";
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
        return array (  125 => 33,  123 => 30,  120 => 29,  114 => 27,  108 => 25,  106 => 24,  101 => 21,  99 => 20,  93 => 16,  85 => 14,  81 => 12,  79 => 11,  73 => 10,  66 => 9,  62 => 8,  55 => 4,  51 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:navbar", "themes/custom/cfc_media_hub/components/navbar/navbar.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 8, "if" => 11, "include" => 20, "embed" => 30];
        static $filters = ["escape" => 3];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "for", 1 => "if", 2 => "include", 3 => "embed"],
                [0 => "escape"],
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


/* cfc_media_hub:navbar */
class __TwigTemplate_a8159f108a3df9381fda68f106067261___1 extends Template
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
        // line 30
        return "cfc_media_hub:button";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--navbar"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:navbar"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:navbar"));
        // line 30
        $this->parent = $this->load("cfc_media_hub:button", 30);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 31
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_label(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Book a space";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:navbar";
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
        return array (  244 => 31,  239 => 30,  235 => 1,  228 => 30,  125 => 33,  123 => 30,  120 => 29,  114 => 27,  108 => 25,  106 => 24,  101 => 21,  99 => 20,  93 => 16,  85 => 14,  81 => 12,  79 => 11,  73 => 10,  66 => 9,  62 => 8,  55 => 4,  51 => 3,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:navbar", "themes/custom/cfc_media_hub/components/navbar/navbar.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["extends" => 30];
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
